<?php

class SPDSGVOEmbeddingsManager
{
    private $registeredEmbeddingApis = [];

    protected function __construct()
    {
        $apis = SPDSGVOEmbeddingApiBase::getAllIntegrationApis(SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS, FALSE);
        $hasValidLicense = isValidPremiumEdition();
        if ($hasValidLicense == false) return;

        foreach($apis as $key => $integration)
        {
            if ($integration->getIsEnabled() == false) continue;

            $this->registeredEmbeddingApis[] = $integration;
        }
    }


    final public static function getInstance()
    {
        static $instances = array();

        $calledClass = get_called_class();

        if (!isset($instances[$calledClass]))
        {
            $instances[$calledClass] = new $calledClass();
        }

        return $instances[$calledClass];
    }

    public function getEmbeddingApiBySlug($slug)
    {
        foreach($this->registeredEmbeddingApis as $key => $integration)
        {
            if ($integration->slug == $slug) return $integration;
        }
        return  null;
    }

    public function findAndProcessIframes($content)
    {
        if (is_admin()) return $content;

        $content = preg_replace_callback('/(\<p\>)?(<iframe.+?(?=<\/iframe>)<\/iframe>){1}(\<\/p\>)?/i', [$this, 'processIframe'], $content);
        return $content;
    }

    public function findAndProcessOembeds($content, $url)
    {
        return $this->processContentBlocking($content, $url);
    }

    public function processIframe($matches)
    {
        $content = $matches[0];

        // Detect host
        $srcUrlOfIframe = [];

        preg_match('/src=("|\')([^"\']{1,})(\1)/i', $matches[2], $srcUrlOfIframe);

        // Skip iframes without src attribute of where src is about:blank
        if (!empty($srcUrlOfIframe[2]) && $srcUrlOfIframe[2] !== 'about:blank') {
            $content = $this->processContentBlocking($matches[0], $srcUrlOfIframe[2]);
        }

        return $content;
    }

    protected function processContentBlocking($content, $urlOfIframe = '')
    {

        if(empty($urlOfIframe)) return $content;

        $currentUrl = parse_url($urlOfIframe);

        // now find which embedding api should be called to process the content
        $found = false;
        $embeddingApi = null;
        if (empty($currentUrl) == false)
        {
            foreach($this->registeredEmbeddingApis as $key => $integration)
            {
                if (empty($integration->hosts)) continue;

                foreach ($integration->getHostsArray() as $host) {

                    if (strpos($currentUrl['host'].$currentUrl['path'], $host) !== false)
                    {
                        $found = true;
                        $embeddingApi = $integration;
                        break;
                    }
                }
                if ($found) break; // break the second loop too
            }
        }
        if ($found == false || $embeddingApi == null) return $content;

        // if its allowed by cookie nothing is to do here. otherwise replace iframes, show image, add optin handler
        if ($embeddingApi->checkIfIntegrationIsAllowed($embeddingApi->slug) == true) return $content;

        $originalContentBase64Encoded = base64_encode(htmlentities($content));
        $processedContent =  $embeddingApi->processContent($content);

        $customCssClasses = SPDSGVOSettings::get('embed_placeholder_custom_css_classes');

        $content = '<div class="sp-dsgvo sp-dsgvo-embedding-container sp-dsgvo-embedding-' . $embeddingApi->slug . ' '. $customCssClasses .'">' . $processedContent . '<div class="sp-dsgvo-hidden-embedding-content sp-dsgvo-hidden-embedding-content-' . $embeddingApi->slug . '" data-sp-dsgvo-embedding-slug="' . $embeddingApi->slug . '">' . $originalContentBase64Encoded . '</div></div>';


        return $content;
    }

    static function getDummyPlaceholderForMutationObserver($embeddingApi)
    {
        $processedContent =  $embeddingApi->processContent('');

        $customCssClasses = SPDSGVOSettings::get('embed_placeholder_custom_css_classes');

        $content = '<div class="sp-dsgvo sp-dsgvo-embedding-container sp-dsgvo-embedding-' . $embeddingApi->slug . ' '. $customCssClasses .'">' . $processedContent . '<div class="sp-dsgvo-hidden-embedding-content sp-dsgvo-hidden-embedding-content-' . $embeddingApi->slug . '" data-sp-dsgvo-embedding-slug="' . $embeddingApi->slug . '">{encodedContent}</div></div>';

        return $content;
    }

}