<?php

class SPDSGVOLinkedInPixelApi extends SPDSGVOIntegrationApiBase
{


    protected function __construct()
    {
        $this->name = "LinkedIn Pixel";
        $this->company = "LinkedIn Ireland Unlimited Company";
        $this->country = "Ireland";
        $this->slug = 'linkedin-pixel';
        $this->storageId = 'linkedinpixel';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_TARGETING;
        $this->cookieNames = 'lidc;bcookie;bscookie;';
        $this->isPremium = true;
        $this->isTagManagerCompatible = true;
        $this->supportedTagManager[] = SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug();
        $this->supportedTagManager[] = SPDSGVOMatomoTagmanagerApi::getInstance()->getSlug();
    }

    public static function getDefaultJsCode($propertyId)
    {
        return "<!-- Your LinkedIn Pixel Code here -->";

    }


}

SPDSGVOLinkedInPixelApi::getInstance()->register();

//add_filter('sp_dsgvo_integrations_head', [SPDSGVOLinkedInPixelApi::getInstance(),'processHeadAction']);
add_filter('sp_dsgvo_integrations_body_end', [SPDSGVOLinkedInPixelApi::getInstance(), 'processBodyEndAction']);