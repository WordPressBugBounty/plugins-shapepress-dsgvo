<?php

class SPDSGVOFacebookFeedIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOFacebookFeedApi::getInstance()->getCategory();
        $this->slug = SPDSGVOFacebookFeedApi::getInstance()->getSlug();
        $this->title = SPDSGVOFacebookFeedApi::getInstance()->getName();
        $this->isPremium = SPDSGVOFacebookFeedApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOFacebookFeedApi::getInstance();
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

SPDSGVOFacebookFeedIntegration::register();