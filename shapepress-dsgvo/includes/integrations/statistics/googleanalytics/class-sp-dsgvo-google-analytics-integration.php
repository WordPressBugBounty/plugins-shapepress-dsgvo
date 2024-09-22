<?php

class SPDSGVOGoogleAnalyticsIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOGoogleAnalyticsApi::getInstance()->getCategory();
        $this->slug = SPDSGVOGoogleAnalyticsApi::getInstance()->getSlug();
        $this->title = SPDSGVOGoogleAnalyticsApi::getInstance()->getName();
        $this->isPremium = SPDSGVOGoogleAnalyticsApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOGoogleAnalyticsApi::getInstance();
	}

	public function view(){
	    if (file_exists(dirname(__FILE__) .'/page.php')) {
            include dirname(__FILE__) . '/page.php';
        }
	}
	
	public function viewSubmit(){

		$this->checkCSRF();
		$this->requireAdmin();

        $settings = SPDSGVOGoogleAnalyticsApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get('ga_enable_analytics', '0');
	    $settings['propertyId'] = $this->get('ga_tag_number', '');
        $settings['useOwnCode'] = $this->get('ga_own_code', '0');
        $settings['usedTagmanager'] = $this->get( $this->slug.'_usedTagmanager', '');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get('ga_code', SPDSGVOGoogleAnalyticsApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOGoogleAnalyticsApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }

        // fallback for older versions
        if ($settings['usedTagmanager'] == '') $settings['withGtm'] = '0';

        SPDSGVOGoogleAnalyticsApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOGoogleAnalyticsIntegration::register();