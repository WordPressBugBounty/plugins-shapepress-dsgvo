<?php

class SPDSGVOGoogleTagmanagerIntegration extends SPDSGVOIntegration{


	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOGoogleTagmanagerApi::getInstance()->getCategory();
        $this->slug = SPDSGVOGoogleTagmanagerApi::getInstance()->getSlug();
        $this->title = SPDSGVOGoogleTagmanagerApi::getInstance()->getName();
        $this->isPremium = SPDSGVOGoogleTagmanagerApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOGoogleTagmanagerApi::getInstance();
	}

	public function view(){
	    if (file_exists(dirname(__FILE__) .'/page.php')) {
            include dirname(__FILE__) . '/page.php';
        }
	}
	
	public function viewSubmit(){

        $hasValidLicense = isValidPremiumEdition();
        if ($hasValidLicense == false)
        {
            $this->redirectBack();
            return;
        }

        $settings = SPDSGVOGoogleTagmanagerApi::getInstance()->getSettings();

        $settings['enabled'] = $this->get('gtag_enable', '0');
	    $settings['propertyId'] = $this->get('gtag_tag_number', '');
        $settings['useOwnCode'] = $this->get('gtag_own_code', '0');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get('gtag_code', SPDSGVOGoogleTagmanagerApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOGoogleTagmanagerApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }


        $settings = SPDSGVOGoogleTagmanagerApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOGoogleTagmanagerIntegration::register();