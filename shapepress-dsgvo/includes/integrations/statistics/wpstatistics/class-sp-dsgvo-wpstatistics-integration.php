<?php

class SPDSGVOWpStatisticsIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOWpStatisticsApi::getInstance()->getCategory();
        $this->slug = SPDSGVOWpStatisticsApi::getInstance()->getSlug();
        $this->title = SPDSGVOWpStatisticsApi::getInstance()->getName();
        $this->isPremium = SPDSGVOWpStatisticsApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOWpStatisticsApi::getInstance();
	}

	public function view(){
	    if (file_exists(dirname(__FILE__) .'/page.php')) {
            include dirname(__FILE__) . '/page.php';
        }
	}
	
	public function viewSubmit(){

		$this->checkCSRF();
		$this->requireAdmin();

        $settings = SPDSGVOWpStatisticsApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');
        $settings['cloudMode'] = '0';
        $settings['useOwnCode'] = '1';//$this->get($this->slug.'_own_code', '1');


        SPDSGVOWpStatisticsApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}

}

SPDSGVOWpStatisticsIntegration::register();