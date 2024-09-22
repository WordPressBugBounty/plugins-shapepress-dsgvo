<?php

class SPDSGVOMatomoTagmanagerIntegration extends SPDSGVOIntegration{


	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOMatomoTagmanagerApi::getInstance()->getCategory();
        $this->slug = SPDSGVOMatomoTagmanagerApi::getInstance()->getSlug();
        $this->title = SPDSGVOMatomoTagmanagerApi::getInstance()->getName();
        $this->isPremium = SPDSGVOMatomoTagmanagerApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOMatomoTagmanagerApi::getInstance();
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

        $settings = SPDSGVOMatomoTagmanagerApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');
        $settings['propertyId'] = $this->get($this->slug.'_tag_number', '');
        $settings['useOwnCode'] = '1';//$this->get($this->slug.'_own_code', '1');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get($this->slug.'_code', SPDSGVOMatomoTagmanagerApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOMatomoTagmanagerApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }


        $settings = SPDSGVOMatomoTagmanagerApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOMatomoTagmanagerIntegration::register();