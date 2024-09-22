<?php

class SPDSGVOGadsenseApi extends SPDSGVOIntegrationApiBase
{
    public $overlayText;

    protected function __construct()
    {
        $this->name = "Google AdSense";
        $this->company = "Google LLC";
        $this->country = "USA";
        $this->slug = 'google-adsense';
        $this->storageId = 'gads';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_TARGETING;
        $this->cookieNames = 'DSID;IDE';
        $this->insertLocation = 'head';
        $this->isPremium = true;
        $this->isTagManagerCompatible = false;
        $this->hosts = 'doubleclick.net';

        $this->overlayText = SPDSGVOLanguageTools::getLwText($this->slug, 'overlay', '');
    }

    public static function getDefaultJsCode($propertyId)
    {
        return "<!-- Google Adsense Code -->
        <script data-ad-client=\"$propertyId\" async src=\"https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
        <!-- End Google Adsense Code -->";

    }

    // copied fro embeddings-manager for special case of adsense
    public function processContent($content)
    {
        // if its allowed by cookie nothing is to do here. otherwise replace iframes, show image, add optin handler
        if ($this->checkIfIntegrationIsAllowed($this->slug) == true) return;

        $replacedContent = $this->getOptInContentReplacementHtml($content);

        return $replacedContent;
    }

    public function getOptInContentReplacementHtml($content)
    {

        $output = '<div class="sp-dsgvo-blocked-embedding-placeholder sp-dsgvo-blocked-embedding-placeholder-'.$this->slug.'">';
        $output .='  <div class="sp-dsgvo-blocked-embedding-placeholder-header"><img class="sp-dsgvo-blocked-embedding-placeholder-header-icon" src="'. SPDSGVO::pluginURI('public/images/embeddings/icon-'.$this->slug .'.svg') .'"/>'.sprintf(__('We need your consent to load the content of %s.','shapepress-dsgvo'), $this->name).'</div>';
        $output .='  <div class="sp-dsgvo-blocked-embedding-placeholder-body">';
        $output .=      $this->overlayText;
        $output .='   <div class="sp-dsgvo-blocked-embedding-button-container"> <a href="#" class="sp-dsgvo-direct-enable-popup sp-dsgvo-blocked-embedding-button-enable" data-slug="'.$this->slug.'">'.__('Click here to enable this content.','shapepress-dsgvo').'</a></div>';
        $output .='  </div>';
        if (empty($this->additionalCss) == false) $output.= '<style>'.$this->additionalCss .'</style>';

        $output .='</div>';

        return $output;
    }
}

SPDSGVOGadsenseApi::getInstance()->register();

add_filter('sp_dsgvo_integrations_head', [SPDSGVOGadsenseApi::getInstance(),'processHeadAction']);
//add_filter('sp_dsgvo_integrations_body_end', [SPDSGVOGadsenseApi::getInstance(), 'processBodyEndAction']);