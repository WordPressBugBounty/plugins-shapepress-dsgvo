<?php

class SPDSGVOSoundcloudApi extends SPDSGVOEmbeddingApiBase
{
    protected function __construct()
    {
        $this->name = "SoundCloud";
        $this->company = "SoundCloud Ltd";
        $this->country = "UK";
        $this->slug = 'soundcloud';
        $this->storageId = 'sc';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS;
        $this->cookieNames = '';
        $this->hosts = 'soundcloud.com';

        parent::__construct();
    }

    public function processContent($content)
    {
        // if its allowed by cookie nothing is to do here. otherwise replace iframes, show image, add optin handler
        if ($this->checkIfIntegrationIsAllowed($this->slug) == true) return;

        $replacedContent = $this->getOptInContentReplacementHtml($content);

        return $replacedContent;
    }
}

SPDSGVOSoundcloudApi::getInstance()->register();