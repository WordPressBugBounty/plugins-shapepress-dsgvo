<?php

class SPDSGVOCriteoApi extends SPDSGVOIntegrationApiBase
{

    protected function __construct()
    {
        $this->name = "Criteo";
        $this->company = "Criteo SA";
        $this->country = "France";
        $this->slug = 'criteo';
        $this->storageId = 'criteo';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_TARGETING;
        $this->cookieNames = 'cto_lwid';
        $this->isPremium = true;
        $this->insertLocation = 'head';
        $this->isTagManagerCompatible = true;
        $this->supportedTagManager[] = SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug();
    }

    public function getDefaultJsCode($propertyId)
    {
        return "<!-- $this->name -->
<script type='text/javascript' src='//static.criteo.net/js/ld/ld.js' async='true'>
</script> <script type='text/javascript'>
window.criteo_q = window.criteo_q || [];
window.criteo_q.push(
         { event: 'setAccount', account: 'YOUR UNIQUE ACCOUNT ID' },
         { event: 'setSiteType', type: 'm FOR MOBILE OR t FOR TABLET OR d FOR DESKTOP' },
         { event: 'setEmail', email: 'TRIMMED AND LOWERCASE USER EMAIL ADDRESS' },
         { event: 'viewHome'} ); </script>
        <!-- End $this->name -->";
    }

}

SPDSGVOCriteoApi::getInstance()->register();

add_filter('sp_dsgvo_integrations_head', [SPDSGVOCriteoApi::getInstance(),'processHeadAction']);
//add_filter('sp_dsgvo_integrations_body_end',[SPDSGVOCriteoApi::getInstance(), 'processBodyEndAction']);