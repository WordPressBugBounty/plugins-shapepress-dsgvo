<?php

class SPDSGVOTwitterIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOTwitterApi::getInstance()->getCategory();
        $this->slug = SPDSGVOTwitterApi::getInstance()->getSlug();
        $this->title = SPDSGVOTwitterApi::getInstance()->getName();
        $this->isPremium = SPDSGVOTwitterApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOTwitterApi::getInstance();
	}

	public function view(){
	    if (file_exists(dirname(__FILE__) .'/page.php')) {
            include dirname(__FILE__) . '/page.php';
        }
	}
	
	public function viewSubmit(){

		$this->requireAdmin();

        $settings = $this->apiInstance->getSettings();

        $settings['isEnabled'] = $this->get( $this->slug.'_enable', '0');


        $this->apiInstance->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOTwitterIntegration::register();