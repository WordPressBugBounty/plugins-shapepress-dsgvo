<?php

class SPDSGVOHotjarApi extends SPDSGVOIntegrationApiBase
{


    protected function __construct()
    {
        $this->name = "Hotjar";
        $this->company = "Hotjar Limited";
        $this->country = "Malta";
        $this->slug = 'hotjar';
        $this->storageId = 'hotjar';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_STATISTICS;
        $this->cookieNames = '';
        $this->isPremium = true;
        $this->isTagManagerCompatible = true;
        $this->supportedTagManager[] = SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug();
    }

    public static function getDefaultJsCode($propertyId)
    {
        return "<!-- Your Hotjar Code here -->";

    }


}

SPDSGVOHotjarApi::getInstance()->register();

add_filter('sp_dsgvo_integrations_head', [SPDSGVOHotjarApi::getInstance(),'processHeadAction']);
//add_filter('sp_dsgvo_integrations_body_end', [SPDSGVOHotjarApi::getInstance(), 'processBodyEndAction']);