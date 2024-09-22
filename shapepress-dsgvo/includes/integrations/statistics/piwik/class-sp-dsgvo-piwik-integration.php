<?php

class SPDSGVOPiwikIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOPiwikApi::getInstance()->getCategory();
        $this->slug = SPDSGVOPiwikApi::getInstance()->getSlug();
        $this->title = SPDSGVOPiwikApi::getInstance()->getName();
        $this->isPremium = SPDSGVOPiwikApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOPiwikApi::getInstance();
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

        $settings = SPDSGVOPiwikApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');
	    $settings['propertyId'] = $this->get($this->slug.'_tag_number', '');
        $settings['useOwnCode'] = '1';//$this->get($this->slug.'_own_code', '1');
        $settings['implementationMode'] = $this->get( $this->slug.'_implementationMode', '');
        $settings['meta']['agency'] = $this->get( $this->slug.'_meta_agency', '');
        $settings['showAsTechMandatory'] = $this->get( $this->slug.'_showAsTechMandatory', '0');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get($this->slug.'_code', SPDSGVOPiwikApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOPiwikApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }


        SPDSGVOPiwikApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}

}

SPDSGVOPiwikIntegration::register();