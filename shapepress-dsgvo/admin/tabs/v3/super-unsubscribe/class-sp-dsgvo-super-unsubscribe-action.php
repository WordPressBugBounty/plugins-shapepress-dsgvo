<?php

Class SPDSGVOSuperUnsubscribeAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-super-unsubscribe';

    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();
   
        if ($this->has('process') == false && $this->get('all') != '1')
        {
            $subform = $this->get('subform');
            if (empty(($subform))) return;

            if ($subform == 'common-settings')
            {
                SPDSGVOSettings::set('unsubscribe_auto_delete', $this->get('unsubscribe_auto_delete', '0'));
                SPDSGVOSettings::set('su_auto_del_time', $this->get('su_auto_del_time', '0'));
                SPDSGVOSettings::set('su_dsgvo_accepted_text', $this->get('su_dsgvo_accepted_text', '', 'wp_kses_post'));

                // Set super_unsubscribe_page
                if($this->has('super_unsubscribe_page')){
                    SPDSGVOSettings::set('super_unsubscribe_page', $this->get('super_unsubscribe_page'));
                }

            }elseif ($subform == 'notification-settings') {

                if (isValidPremiumEdition())
                {
                    SPDSGVOSettings::set('su_email_notification', $this->get('su_email_notification', '0'));
                    SPDSGVOSettings::set('su_email_title', $this->get('su_email_title', ''));
                    SPDSGVOSettings::set('su_email_content', $this->get('su_email_content', '', 'wp_kses_post'));
                }
            } elseif ($subform == 'integration-settings') {
                if (isValidPremiumEdition())
                {
                    SPDSGVOSettings::set('su_woo_data_action', $this->get('su_woo_data_action', 'ignore'));
                    SPDSGVOSettings::set('su_bbpress_data_action', $this->get('su_bbpress_data_action', 'ignore'));
                    SPDSGVOSettings::set('su_buddypress_data_action', $this->get('su_buddypress_data_action', 'ignore'));
                    SPDSGVOSettings::set('su_cf7_data_action', $this->get('su_cf7_data_action', 'ignore'));
                }
            }

                        
            // unsubscribe_auto_delete        





        }

        // Unsubscribe single user
        if($this->has('process')){
            $unsubscriber = SPDSGVOUnsubscriber::find($this->get('process'));
            if(isset($unsubscriber)){
                $unsubscriber->doSuperUnsubscribe();
            }
        }


        // Unsubscribe all
        if($this->get('all') == '1'){
            foreach(SPDSGVOUnsubscriber::all() as $unsubscriber){
                $unsubscriber->doSuperUnsubscribe();
            }
        }


    	$this->returnBack();
    }
}

SPDSGVOSuperUnsubscribeAction::listen();
