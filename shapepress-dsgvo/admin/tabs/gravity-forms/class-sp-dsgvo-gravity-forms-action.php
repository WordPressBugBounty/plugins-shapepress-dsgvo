<?php

Class SPDSGVOGravityFormsAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-gravity-forms';

    protected function run(){
        $this->checkCSRF();
    	$this->requireAdmin();

        SPDSGVOSettings::set('gf_save_no_data', $this->get('gf_save_no_data'), '0');
        
        SPDSGVOSettings::set('gf_no_ip_meta', $this->get('gf_no_ip_meta'), '0');

        SPDSGVOSettings::set('gf_save_no_', $this->get('gf_save_no_'), []);
        
        $this->returnBack();
    }
}

SPDSGVOGravityFormsAction::listen();


