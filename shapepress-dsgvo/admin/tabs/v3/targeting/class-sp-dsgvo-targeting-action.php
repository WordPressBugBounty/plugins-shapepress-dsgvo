<?php

Class SPDSGVOTargetingIntegrationAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-targeting-integrations';




    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();


        $this->returnBack();
    }
}

SPDSGVOTargetingIntegrationAction::listen();
