<?php

class SPDSGVOGadsenseIntegration extends SPDSGVOIntegration{


	public function __construct()
    {
       $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOGadsenseApi::getInstance()->getCategory();
        $this->slug = SPDSGVOGadsenseApi::getInstance()->getSlug();
        $this->title = SPDSGVOGadsenseApi::getInstance()->getName();
        $this->isPremium = SPDSGVOGadsenseApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOGadsenseApi::getInstance();
	}

	public function view(){
	    if (file_exists(dirname(__FILE__) .'/page.php')) {
            include dirname(__FILE__) . '/page.php';
        }
	}
	
	public function viewSubmit(){

		$this->checkCSRF();
		$this->requireAdmin();

        $hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();
        if ($hasValidLicense == false)
        {
            $this->redirectBack();
            return;
        }

        $settings = SPDSGVOFbPixelApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');
        $settings['propertyId'] = $this->get($this->slug.'_property_id', '');
        $settings['useOwnCode'] = $this->get($this->slug.'_own_code', '0');
        $settings['usedTagmanager'] = $this->get( $this->slug.'_usedTagmanager', '');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get($this->slug.'_code', SPDSGVOGadsenseApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOGadsenseApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }

        // fallback for older versions
        if ($settings['usedTagmanager'] == '') $settings['withGtm'] = '0';

        SPDSGVOGadsenseApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOGadsenseIntegration::register();