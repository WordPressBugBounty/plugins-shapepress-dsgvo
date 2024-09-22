<?php

Class SPDSGVOImprintAction extends SPDSGVOAjaxAction{

    protected $action = 'imprint';

    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();


        $subform = $this->get('subform');
        if (empty(($subform))) return;

        if ($subform == 'imprint-settings')
        {
            if($this->has('imprint_page')){
                SPDSGVOSettings::set('imprint_page', $this->get('imprint_page', '0'));
            }
        } elseif ($subform == 'imprint-content')
        {
            // Update imprint
            if($this->has('imprint')){
                SPDSGVOSettings::set('imprint_hash', wp_hash($this->get('imprint')));
                SPDSGVOSettings::set('imprint', $this->get('imprint', NULL, 'wp_kses_post'));
                SPDSGVOLog::insert("Imprint updated by {$this->user->user_email}");
            }
        }

        $this->returnBack();
    }
}

SPDSGVOImprintAction::listen();
