<?php

class SPDSGVOClickyIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOClickyApi::getInstance()->getCategory();
        $this->slug = SPDSGVOClickyApi::getInstance()->getSlug();
        $this->title = SPDSGVOClickyApi::getInstance()->getName();
        $this->isPremium = SPDSGVOClickyApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOClickyApi::getInstance();
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

        $settings = SPDSGVOClickyApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');
	    $settings['propertyId'] = $this->get($this->slug.'_property_id', '');
        $settings['useOwnCode'] = $this->get($this->slug.'_own_code', '0');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get($this->slug.'_code', SPDSGVOClickyApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOClickyApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }


        SPDSGVOClickyApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}

}

SPDSGVOClickyIntegration::register();