<?php

class SPDSGVOWpStatisticsApi extends SPDSGVOIntegrationApiBase
{

    protected function __construct()
    {
        $this->name = "WP Statistics";
        $this->company = "VeronaLabs";
        $this->country = "New Zealand";
        $this->slug = 'wp-statistics';
        $this->storageId = 'wpstatistics';
        $this->cookieCategory  = SPDSGVOConstants::CATEGORY_SLUG_STATISTICS;
        $this->cookieNames = '';
        $this->insertLocation = 'head';
        $this->optionTechMandatory = true;
    }

    public function getDefaultJsCode($propertyId)
    {

        return "";
    }

    public function getIfOptInNeeded()
    {
        $settings = $this->getSettings();
        if ($this->optionTechMandatory == true && $settings['showAsTechMandatory'] == 1) return false;

        return false;
    }

    public function getShowInPopup()
    {
        $settings = $this->getSettings();

        if (SPDSGVOSettings::get('force_cookie_info') == '1') return true;
        else return false;
    }

    public function getSettings()
    {
        $settings =  parent::getSettings();
        $settings['showAsTechMandatory'] = '1';

        return $settings;
    }
}

SPDSGVOWpStatisticsApi::getInstance()->register();

//add_filter('sp_dsgvo_integrations_head', [SPDSGVOWpStatisticsApi::getInstance(),'processHeadAction']);
//add_filter('sp_dsgvo_integrations_body_end',[SPDSGVOWpStatisticsApi::getInstance(), 'processBodyEndAction']);