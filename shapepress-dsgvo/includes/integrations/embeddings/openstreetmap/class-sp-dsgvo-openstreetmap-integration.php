<?php

class SPDSGVOOpenstreetmapIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOOpenstreetmapApi::getInstance()->getCategory();
        $this->slug = SPDSGVOOpenstreetmapApi::getInstance()->getSlug();
        $this->title = SPDSGVOOpenstreetmapApi::getInstance()->getName();
        $this->isPremium = SPDSGVOOpenstreetmapApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOOpenstreetmapApi::getInstance();
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
        if (is_array($legacySettings) && in_array('open-street-map', $legacySettings))
        {
            $legacySettings = array_diff($legacySettings, array('open-street-map'));
            SPDSGVOSettings::set('page_basics_embeddings',$legacySettings);
        }

        $this->apiInstance->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOOpenstreetmapIntegration::register();