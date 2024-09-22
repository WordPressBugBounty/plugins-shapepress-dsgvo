<?php

class SPDSGVOFbPixelIntegration extends SPDSGVOIntegration{


	public function __construct()
    {
       $this->boot();
    }

    public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOFbPixelApi::getInstance()->getCategory();
        $this->slug = SPDSGVOFbPixelApi::getInstance()->getSlug();
        $this->title = SPDSGVOFbPixelApi::getInstance()->getName();
        $this->isPremium = SPDSGVOFbPixelApi::getInstance()->getIsPremium();
        $this->apiInstance = SPDSGVOFbPixelApi::getInstance();
	}

	public function view(){
	    if (file_exists(dirname(__FILE__) .'/page.php')) {
            include dirname(__FILE__) . '/page.php';
        }
	}
	
	public function viewSubmit(){

		$this->checkCSRF();
		$this->requireAdmin();

        $hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();
        if ($hasValidLicense == false)
        {
            $this->redirectBack();
            return;
        }

        $settings = SPDSGVOFbPixelApi::getInstance()->getSettings();

        $settings['isEnabled'] = $this->get('fb_enable_pixel', '0');
	    $settings['propertyId'] = $this->get('fb_pixel_number', '');
        $settings['useOwnCode'] = $this->get('fb_own_code', '0');
        $settings['usedTagmanager'] = $this->get( $this->slug.'_usedTagmanager', '');
        if ($settings['useOwnCode'] == '1')
        {
            $settings['jsCode'] = $this->get('fbpixel_code', SPDSGVOFbPixelApi::getInstance()->getDefaultJsCode($settings['propertyId']), 'wp_kses_scripts');
        } else
        {
            $settings['jsCode'] = $this->get(SPDSGVOFbPixelApi::getInstance()->getDefaultJsCode($settings['propertyId']));
        }

        // fallback for older versions
        if ($settings['usedTagmanager'] == '') $settings['withGtm'] = '0';

        SPDSGVOFbPixelApi::getInstance()->setSettings($settings);

		$this->redirectBack();
	}



}

SPDSGVOFbPixelIntegration::register();