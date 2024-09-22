<?php

class SPDSGVOSoundcloudIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOSoundcloudApi::getInstance()->getCategory();
        $this->slug = SPDSGVOSoundcloudApi::getInstance()->getSlug();
        $this->title = SPDSGVOSoundcloudApi::getInstance()->getName();
        $this->isPremium = SPDSGVOSoundcloudApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOSoundcloudApi::getInstance();
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

SPDSGVOSoundcloudIntegration::register();