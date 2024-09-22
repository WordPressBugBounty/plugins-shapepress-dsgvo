<?php

class SPDSGVOVimeoIntegration extends SPDSGVOIntegration{

	public function __construct()
    {
        $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOVimeoApi::getInstance()->getCategory();
        $this->slug = SPDSGVOVimeoApi::getInstance()->getSlug();
        $this->title = SPDSGVOVimeoApi::getInstance()->getName();
        $this->isPremium = SPDSGVOVimeoApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOVimeoApi::getInstance();
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
        if (is_array($legacySettings) && in_array('vimeo', $legacySettings))
        {
            $legacySettings = array_diff($legacySettings, array('vimeo'));
            SPDSGVOSettings::set('page_basics_embeddings',$legacySettings);
        }

        $this->apiInstance->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOVimeoIntegration::register();