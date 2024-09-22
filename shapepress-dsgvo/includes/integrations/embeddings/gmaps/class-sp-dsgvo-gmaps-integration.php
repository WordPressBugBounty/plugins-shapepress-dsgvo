<?php

class SPDSGVOGmapsIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOGmapsApi::getInstance()->getCategory();
        $this->slug = SPDSGVOGmapsApi::getInstance()->getSlug();
        $this->title = SPDSGVOGmapsApi::getInstance()->getName();
        $this->isPremium = SPDSGVOGmapsApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOGmapsApi::getInstance();
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

        // delete old setting from times before we had embeddings
        $legacySettings = SPDSGVOSettings::get('page_basics_embeddings');
        if (is_array($legacySettings) && in_array('google-maps', $legacySettings))
        {
            $legacySettings = array_diff($legacySettings, array('google-maps'));
            SPDSGVOSettings::set('page_basics_embeddings',$legacySettings);
        }


        $this->apiInstance->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOGmapsIntegration::register();