<?php

class SPDSGVOEtrackerIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOEtrackerApi::getInstance()->getCategory();
        $this->slug = SPDSGVOEtrackerApi::getInstance()->getSlug();
        $this->title = SPDSGVOEtrackerApi::getInstance()->getName();
        $this->isPremium = SPDSGVOEtrackerApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOEtrackerApi::getInstance();
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

        $settings = SPDSGVOEtrackerApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');
	    $settings['propertyId'] = $this->get($this->slug.'_property_id', '');
        $settings['useOwnCode'] = $this->get($this->slug.'_own_code', '0');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get($this->slug.'_code', SPDSGVOEtrackerApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOEtrackerApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }


        SPDSGVOEtrackerApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}

}

SPDSGVOEtrackerIntegration::register();