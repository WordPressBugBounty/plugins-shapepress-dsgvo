<?php

class SPDSGVOMatomoIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOMatomoApi::getInstance()->getCategory();
        $this->slug = SPDSGVOMatomoApi::getInstance()->getSlug();
        $this->title = SPDSGVOMatomoApi::getInstance()->getName();
        $this->isPremium = SPDSGVOMatomoApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOMatomoApi::getInstance();
	}

	public function view(){
	    if (file_exists(dirname(__FILE__) .'/page.php')) {
            include dirname(__FILE__) . '/page.php';
        }
	}
	
	public function viewSubmit(){

		$this->checkCSRF();
		$this->requireAdmin();

        $settings = SPDSGVOMatomoApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');
	    $settings['propertyId'] = $this->get($this->slug.'_tag_number', '');
        $settings['implementationMode'] = $this->get( $this->slug.'_implementationMode', '');
        $settings['meta']['agency'] = $this->get( $this->slug.'_meta_agency', '');
        $settings['showAsTechMandatory'] = $this->get( $this->slug.'_showAsTechMandatory', '0');
        $settings['useOwnCode'] = '1';//$this->get($this->slug.'_own_code', '1');
        $settings['usedTagmanager'] = $this->get( $this->slug.'_usedTagmanager', '');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get($this->slug.'_code', SPDSGVOMatomoApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOMatomoApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }

        SPDSGVOMatomoApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}

}

SPDSGVOMatomoIntegration::register();