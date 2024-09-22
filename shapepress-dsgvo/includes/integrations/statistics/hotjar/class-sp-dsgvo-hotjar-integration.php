<?php

class SPDSGVOHotjarIntegration extends SPDSGVOIntegration{


	public function __construct()
    {
       $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOHotjarApi::getInstance()->getCategory();
        $this->slug = SPDSGVOHotjarApi::getInstance()->getSlug();
        $this->title = SPDSGVOHotjarApi::getInstance()->getName();
        $this->isPremium = SPDSGVOHotjarApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOHotjarApi::getInstance();
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

        $settings = SPDSGVOHotjarApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');
        $settings['propertyId'] = $this->get($this->slug.'_tag_number', '');
        $settings['useOwnCode'] = '1';//$this->get($this->slug.'_own_code', '1');
        $settings['usedTagmanager'] = $this->get( $this->slug.'_usedTagmanager', '');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get($this->slug.'_code', SPDSGVOHotjarApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOHotjarApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }

        // fallback for older versions
        if ($settings['usedTagmanager'] == '') $settings['withGtm'] = '0';

        SPDSGVOHotjarApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOHotjarIntegration::register();