<?php

Class SPDSGVOCreatePageAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-create-page';

    protected function run(){
    	$this->requireAdmin();

        // Init Settings
        if(class_exists('SPDSGVOLog')){
            if(SPDSGVOLog::tableExists() === FALSE){
                if(class_exists('SPDSGVOSettings')){
                    SPDSGVOSettings::init();
                }

                SPDSGVOLog::migrate();
                SPDSGVOLog::insert(__('Plugin installed', 'shapepress-dsgvo'));
            }
        }


        // License Key
        if($this->has('license_key')){
            SPDSGVOSettings::set('show_setup', '0');
            SPDSGVOSettings::set('license_key', $this->get('license_key'));
        }


        // Create Pages (set-up page)
        if($this->has('display_cookie_notice')){
            SPDSGVOSettings::set('display_cookie_notice', '1');
        }

        if($this->has('sar')){
            $ID = $this->createPage(__('Subject Access Request','shapepress-dsgvo'), '[sar_form]');
            SPDSGVOSettings::set('sar_page', $ID);
        }

        if($this->has('user_privacy_settings_page')){
            $ID = $this->createPage(__('User privacy settings','shapepress-dsgvo'), '[user_privacy_settings_form]');
            SPDSGVOSettings::set('user_permissions_page', $ID);
        }

        if($this->has('terms_conditions_page')){
            $ID = $this->createPage(__('Terms & Conditions', 'shapepress-dsgvo'), '[terms_conditions]');
            SPDSGVOSettings::set('terms_conditions_page', $ID);
        }

        if($this->has('privacy_policy_page')){
            $ID = $this->createPage(__('Privacy Policy','shapepress-dsgvo'), '[privacy_policy]');
            SPDSGVOSettings::set('privacy_policy_page', $ID);
        }

        if($this->has('super_unsubscribe_page')){
            $ID = $this->createPage(__('Delete Request','shapepress-dsgvo'), '[unsubscribe_form]');
            SPDSGVOSettings::set('super_unsubscribe_page', $ID);
        }

        
        if($this->has('imprint_page')){
            $ID = $this->createPage(__('Imprint','shapepress-dsgvo'), '[imprint]');
            SPDSGVOSettings::set('imprint_page', $ID);
        }
        
        // Other Pages
        if($this->has('explicit_permission_page')){
            $ID = $this->createPage(__('Terms & Conditions', 'shapepress-dsgvo'), '[explicit_permission]');
            SPDSGVOSettings::set('explicit_permission_page', $ID);
        }
        

        
        if($this->has('opt_out_page')){
            $ID = $this->createPage(__('Opt-out', 'shapepress-dsgvo'), '[decline_permission]');
            SPDSGVOSettings::set('opt_out_page', $ID);
        }
        

        // Show Set Up
        if($this->has('show_setup')){
            SPDSGVOSettings::set('show_setup', '1');
        }


        $this->returnBack();
    }


    public function createPage($title, $content){
    	return wp_insert_post(array(
    		'post_title' 	=> $title,
    		'post_content' 	=> $content,
    		'post_type' 	=> 'page',
    		'post_status'	=> 'publish'
    	));
    }

}

SPDSGVOCreatePageAction::listen();
