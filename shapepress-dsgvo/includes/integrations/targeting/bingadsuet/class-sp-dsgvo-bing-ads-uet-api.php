<?php

class SPDSGVOBingAdsUetApi extends SPDSGVOIntegrationApiBase
{


    protected function __construct()
    {
        $this->name = "Bing Ads";
        $this->company = "Microsoft Corporation";
        $this->country = "Ireland";
        $this->slug = 'bing-ads-uet';
        $this->storageId = 'bingadsuet';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_TARGETING;
        $this->cookieNames = '';
        $this->isPremium = true;
        $this->isTagManagerCompatible = true;
        $this->supportedTagManager[] = SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug();
        $this->supportedTagManager[] = SPDSGVOMatomoTagmanagerApi::getInstance()->getSlug();
    }

    public static function getDefaultJsCode($propertyId)
    {
        return "<!-- Your Bing Ads UET Code here -->";

    }


}

SPDSGVOBingAdsUetApi::getInstance()->register();

add_filter('sp_dsgvo_integrations_head', [SPDSGVOBingAdsUetApi::getInstance(),'processHeadAction']);
//add_filter('sp_dsgvo_integrations_body_end', [SPDSGVOLinkedInPixelApi::getInstance(), 'processBodyEndAction']);