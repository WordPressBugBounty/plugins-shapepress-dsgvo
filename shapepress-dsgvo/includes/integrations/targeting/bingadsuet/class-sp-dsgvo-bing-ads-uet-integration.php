<?php

class SPDSGVOBingAdsUetIntegration extends SPDSGVOIntegration{


	public function __construct()
    {
       $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOBingAdsUetApi::getInstance()->getCategory();
        $this->slug = SPDSGVOBingAdsUetApi::getInstance()->getSlug();
        $this->title = SPDSGVOBingAdsUetApi::getInstance()->getName();
        $this->isPremium = SPDSGVOBingAdsUetApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOBingAdsUetApi::getInstance();
	}

	public function view(){
	    if (file_exists(dirname(__FILE__) .'/page.php')) {
            include dirname(__FILE__) . '/page.php';
        }
	}
	
	public function viewSubmit(){

		$this->checkCSRF();
		$this->requireAdmin();

        $hasValidLicense = isValidPremiumEdition();
        if ($hasValidLicense == false)
        {
            $this->redirectBack();
            return;
        }

        $settings = SPDSGVOBingAdsUetApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');
        $settings['propertyId'] = $this->get($this->slug.'_tag_number', '');
        $settings['useOwnCode'] = '1';//$this->get($this->slug.'_own_code', '1');
        $settings['usedTagmanager'] = $this->get( $this->slug.'_usedTagmanager', '');

        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get($this->slug.'_code', SPDSGVOBingAdsUetApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOBingAdsUetApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }

        // fallback for older versions
        if ($settings['usedTagmanager'] == '') $settings['withGtm'] = '0';

        SPDSGVOBingAdsUetApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOBingAdsUetIntegration::register();