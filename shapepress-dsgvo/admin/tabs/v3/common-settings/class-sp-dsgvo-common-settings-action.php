<?php

Class SPDSGVOCommonSettingsAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-common-settings';

    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();


        $subform = $this->get('subform');
        if (empty(($subform))) return;

        if ($subform == 'common-settings')
        {
            SPDSGVOSettings::set('admin_email', $this->get('admin_email', NULL, 'sanitize_email'));
            SPDSGVOSettings::set('dsgvo_auto_update',  $this->get('dsgvo_auto_update', '0'));
        } elseif ($subform == 'forms')
        {
            /*
             * not needed for now
            SPDSGVOSettings::set('sp_dsgvo_comments_checkbox', $this->get('sp_dsgvo_comments_checkbox', '0'));
            SPDSGVOSettings::set('spdsgvo_comments_checkbox_text', $this->get('spdsgvo_comments_checkbox_text', ''));

            SPDSGVOSettings::set('sp_dsgvo_cf7_acceptance_replace', $this->get('sp_dsgvo_cf7_acceptance_replace', '0'));

            SPDSGVOSettings::set('wp_signup_show_privacy_checkbox', $this->get('wp_signup_show_privacy_checkbox', '0'));
            SPDSGVOSettings::set('wp_signup_checkbox_text', $this->get('wp_signup_checkbox_text', ''));
            */
            SPDSGVOSettings::set('woo_show_privacy_checkbox', $this->get('woo_show_privacy_checkbox', '0'));
            SPDSGVOSettings::set('woo_privacy_text', $this->get('woo_privacy_text', '', 'wp_kses_post'));

        }


        $this->returnBack();
    }
}

SPDSGVOCommonSettingsAction::listen();
