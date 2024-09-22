<?php

Class SPDSGVOAdminSubjectAccessRequestAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-subject-access-request';

    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();

        if ($this->has('process') == false && $this->get('all') != '1')
        {
            $subform = $this->get('subform');
            if (empty(($subform))) return;

            if ($subform == 'common-settings')
            {
                SPDSGVOSettings::set('sar_cron', $this->get('sar_cron', '0'));
                SPDSGVOSettings::set('sar_dsgvo_accepted_text', $this->get('sar_dsgvo_accepted_text', '', 'wp_kses_post'));
                if($this->has('sar_page')){
                    SPDSGVOSettings::set('sar_page', $this->get('sar_page'));
                }

            } elseif ($subform == 'notification-settings')
            {
                if (isValidPremiumEdition())
                {
                    SPDSGVOSettings::set('sar_email_notification', $this->get('sar_email_notification', '0'));
                    SPDSGVOSettings::set('sar_email_title', $this->get('sar_email_title', ''));
                    SPDSGVOSettings::set('sar_email_content', $this->get('sar_email_content', '', 'wp_kses_post'));
                }
            }

        }

        if($this->has('process')){
            $ID = $this->get('process');
            SPDSGVOSubjectAccessRequest::doByID($ID);
        }

        if($this->get('all') == '1'){
            foreach(SPDSGVOSubjectAccessRequest::finder('pending') as $sar){
                $sar->doSubjectAccessRequest();
            }
        }


    	$this->returnBack();
    }
}

SPDSGVOAdminSubjectAccessRequestAction::listen();
