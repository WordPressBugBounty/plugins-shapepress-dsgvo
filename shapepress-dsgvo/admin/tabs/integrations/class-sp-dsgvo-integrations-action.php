<?php

Class SPDSGVOIntegrationsAction extends SPDSGVOAjaxAction{

    protected $action = 'SPDSGVO-integrations-submit';

    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();

        $time = time();
        SPDSGVOSettings::set('integration_enable_key', $time);

        foreach($this->get('integrations') as $integrationSlug => $value){
        	SPDSGVOSettings::set('is_enabled_'. $integrationSlug, $time);
        }
       
    	$this->returnBack();
    }
}

SPDSGVOIntegrationsAction::listen();
