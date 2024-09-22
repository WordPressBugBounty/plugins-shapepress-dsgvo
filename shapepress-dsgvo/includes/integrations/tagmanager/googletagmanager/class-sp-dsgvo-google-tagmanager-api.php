<?php

class SPDSGVOGoogleTagmanagerApi extends SPDSGVOIntegrationApiBase
{


    protected function __construct()
    {
        $this->name = "Google Tagmanager";
        $this->company = "Google LLC";
        $this->country = "USA";
        $this->slug = 'google-tagmanager';
        $this->storageId = 'gtag';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_TAGMANAGER;
        $this->cookieNames = '_ga;_gat;_gid';
        $this->isPremium = true;
        $this->insertLocation = 'head';
        $this->optInNeeded = true;
    }

    public static function getDefaultJsCode($propertyId)
    {
        return "<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','$propertyId');</script>
<!-- End Google Tag Manager -->";

    }

    public function processHeadAction()
    {
        if ($this->insertLocation != 'head') return;

        $settings = $this->getSettings();

        if ($settings['isEnabled'] == '0') return;
        $propertyId = $settings['propertyId'];

        $integrationAllowed = $this->checkIfIntegrationIsAllowedByCookie($settings);

        $jsCode = $this->getJsCode($settings);

        $result = "";

        $result = "<!-- id='sp-dsgvo-script-container-$this->slug' class='sp-dsgvo-script-container'-->$jsCode<!-- end sp-dsgvo-script-container-$this->slug -->";
        if ($integrationAllowed) {
            echo wp_kses($result, $this->getAllowedHtmlForScriptsForKses());
        }
        return;
    }

    public function processBodyStartAction()
    {
        $settings = $this->getSettings();

        if ($settings['isEnabled'] == '0') return;
        $propertyId = $settings['propertyId'];

        $integrationAllowed = $this->checkIfIntegrationIsAllowed($this->slug);
        $jsCode = "<!-- Google Tag Manager (noscript) -->
<noscript><iframe src='https://www.googletagmanager.com/ns.html?id=$propertyId'
height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->";

        $result = "";

        $result = "<div class='sp-dsgvo-script-container sp-dsgvo-script-container-$this->slug'>
                $jsCode<!-- hook body start-->
             </div>";

        if ($integrationAllowed) {
	        echo wp_kses($result, $this->getAllowedHtmlForScriptsForKses());
        }
        return;
    }
}

SPDSGVOGoogleTagmanagerApi::getInstance()->register();

add_filter('sp_dsgvo_integrations_head', [SPDSGVOGoogleTagmanagerApi::getInstance(),'processHeadAction']);
add_filter('sp_dsgvo_integrations_body_start', [SPDSGVOGoogleTagmanagerApi::getInstance(), 'processBodyStartAction']);
add_filter('sp_dsgvo_integrations_body_end', [SPDSGVOGoogleTagmanagerApi::getInstance(), 'processBodyEndAction']);