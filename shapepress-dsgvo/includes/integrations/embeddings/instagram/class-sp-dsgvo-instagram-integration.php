<?php

class SPDSGVOInstagramIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOInstagramApi::getInstance()->getCategory();
        $this->slug = SPDSGVOInstagramApi::getInstance()->getSlug();
        $this->title = SPDSGVOInstagramApi::getInstance()->getName();
        $this->isPremium = SPDSGVOInstagramApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOInstagramApi::getInstance();
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

SPDSGVOInstagramIntegration::register();