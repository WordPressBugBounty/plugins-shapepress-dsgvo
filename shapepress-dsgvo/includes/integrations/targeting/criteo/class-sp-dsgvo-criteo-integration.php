<?php

class SPDSGVOCriteoIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOCriteoApi::getInstance()->getCategory();
        $this->slug = SPDSGVOCriteoApi::getInstance()->getSlug();
        $this->title = SPDSGVOCriteoApi::getInstance()->getName();
        $this->isPremium = SPDSGVOCriteoApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOCriteoApi::getInstance();
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

        $settings = SPDSGVOCriteoApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');
	    $settings['propertyId'] = $this->get($this->slug.'_tag_number', '');
        $settings['useOwnCode'] = '1';//$this->get($this->slug.'_own_code', '1');
        $settings['usedTagmanager'] = $this->get( $this->slug.'_usedTagmanager', '');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get($this->slug.'_code', SPDSGVOCriteoApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOCriteoApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }

        // fallback for older versions
        if ($settings['usedTagmanager'] == '') $settings['withGtm'] = '0';

        SPDSGVOCriteoApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}

}

SPDSGVOCriteoIntegration::register();