<?php

class SPDSGVOMatomoTagmanagerApi extends SPDSGVOIntegrationApiBase
{


    protected function __construct()
    {
        $this->name = "Matomo Tagmanager";
        $this->company = "InnoCraft Ltd";
        $this->country = "New Zealand";
        $this->slug = 'matomo-tagmanager';
        $this->storageId = 'mtag';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_TAGMANAGER;
        $this->cookieNames = '_pk_*.*';
        $this->insertLocation = 'head';
        $this->optInNeeded = false;
    }

    public static function getDefaultJsCode($propertyId)
    {
        return "<!-- Matomo Tag Manager -->
<script>
var _mtm = _mtm || [];
_mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
g.type='text/javascript'; g.async=true; g.defer=true; g.src='YOUR_URL_HERE'; s.parentNode.insertBefore(g,s);
</script>
<!-- End Matomo Tag Manager -->";

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

        return;
    }
}

SPDSGVOMatomoTagmanagerApi::getInstance()->register();

add_filter('sp_dsgvo_integrations_head', [SPDSGVOMatomoTagmanagerApi::getInstance(),'processHeadAction']);
//add_filter('sp_dsgvo_integrations_body_start', [SPDSGVOMatomoTagmanagerApi::getInstance(), 'processBodyStartAction']);
//add_filter('sp_dsgvo_integrations_body_end', [SPDSGVOMatomoTagmanagerApi::getInstance(), 'processBodyEndAction']);