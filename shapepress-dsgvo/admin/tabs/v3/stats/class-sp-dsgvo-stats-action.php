<?php

Class SPDSGVOStatisticIntegrationAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-statistic-integrations';




    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();


        $this->returnBack();
    }
}

SPDSGVOStatisticIntegrationAction::listen();
