<?php

Class SPDSGVOTagmanagerIntegrationAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-tagmanager-integrations';




    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();


        $this->returnBack();
    }
}

SPDSGVOTagmanagerIntegrationAction::listen();
