<?php

Class SPDSGVOAdminAction extends SPDSGVOAjaxAction{
    
    protected $action = 'admin-common-action';
    
    protected function run(){
        $this->requireAdmin();
        
        SPDSGVOSettings::set('cb_spdsgvo_cl_vdv', $this->get('cb_spdsgvo_cl_vdv', '0'));
        SPDSGVOSettings::set('cb_spdsgvo_cl_filled_out', $this->get('cb_spdsgvo_cl_filled_out', '0'));
        SPDSGVOSettings::set('cb_spdsgvo_cl_maintainance', $this->get('cb_spdsgvo_cl_maintainance', '0'));
        SPDSGVOSettings::set('cb_spdsgvo_cl_security', $this->get('cb_spdsgvo_cl_security', '0'));
        SPDSGVOSettings::set('cb_spdsgvo_cl_hosting', $this->get('cb_spdsgvo_cl_hosting', '0'));
        SPDSGVOSettings::set('cb_spdsgvo_cl_plugins', $this->get('cb_spdsgvo_cl_plugins', '0'));
        SPDSGVOSettings::set('cb_spdsgvo_cl_experts', $this->get('cb_spdsgvo_cl_experts', '0'));

        $this->returnBack();
    }
}

SPDSGVOAdminAction::listen();


