<?php

Class SPDSGVOPrivacyPolicyAction extends SPDSGVOAjaxAction
{

    protected $action = 'privacy-policy';

    protected function run()
    {
        $this->checkCSRF();
        $this->requireAdmin();


        // Set privacy policy page
        if ($this->has('privacy_policy_page')) {
            SPDSGVOSettings::set('privacy_policy_page', $this->get('privacy_policy_page', '0'));
            update_option('wp_page_for_privacy_policy', $this->get('privacy_policy_page', '0'));
        }

        SPDSGVOSettings::set('privacy_policy_custom_header', $this->get('privacy_policy_custom_header', ''));

        SPDSGVOSettings::set('privacy_policy_title_html_htag', $this->get('privacy_policy_title_html_htag', 'h1'));
        SPDSGVOSettings::set('privacy_policy_subtitle_html_htag', $this->get('privacy_policy_subtitle_html_htag', 'h2'));
        SPDSGVOSettings::set('privacy_policy_subsubtitle_html_htag', $this->get('privacy_policy_subsubtitle_html_htag', 'h3'));


        SPDSGVOSettings::set('woo_show_privacy_checkbox', $this->get('woo_show_privacy_checkbox', '0'));
        SPDSGVOSettings::set('woo_show_privacy_checkbox_register', $this->get('woo_show_privacy_checkbox_register', '0'));
        /* i592995 */
        SPDSGVOSettings::set('woo_privacy_text', $this->get('woo_privacy_text', '', 'sanitize_textarea_field'));
        /* i592995 */

        SPDSGVOSettings::set('pp_texts_notification_mail', $this->get('pp_texts_notification_mail', '0'));

        // Update privacy policy
        if ($this->has('privacy_policy')) {
            $version = SPDSGVOSettings::get('privacy_policy_version');
            $version = intval($version);
            $version++;
            $version = SPDSGVOSettings::set('privacy_policy_version', $version);
            SPDSGVOSettings::set('privacy_policy_hash', wp_hash($this->get('privacy_policy')));
            SPDSGVOSettings::set('privacy_policy', $this->get('privacy_policy'));
            SPDSGVOLog::insert("Privacy policy updated by {$this->user->user_email}");
        }

        SPDSGVOSettings::set('wp_signup_show_privacy_checkbox', $this->get('wp_signup_show_privacy_checkbox', '0'));
        SPDSGVOSettings::set('wp_signup_checkbox_text', $this->get('wp_signup_checkbox_text', ''));

        $this->returnBack();
    }
}

SPDSGVOPrivacyPolicyAction::listen();
