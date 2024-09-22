<?php

Class SPDSGVONoticeAction extends SPDSGVOAjaxAction{

    protected $action = 'notice-action';

    protected function run(){
	    error_log('notice-action: run');
		$this->requireAdmin();

        $noticeKey = $this->get('id');
	    error_log('notice-action: '.$noticeKey);
        
        if ($noticeKey == NULL || $noticeKey == '')
        {
            echo "invalid notice key";
            die;
        }
        
        if ($noticeKey == 'google-gdpr-refresh-notice') {
            SPDSGVOSettings::set('google_gdpr_refresh_notice', '1');
        }

        if ($noticeKey == 'license-invalid-notice')
        {
            SPDSGVOSettings::set('show_invalid_license_notice', '0');
        }
        
        if ($noticeKey == 'license-revoke-notice')
        {
            SPDSGVOSettings::set('show_revoke_license_notice', '0');
        }

        if ($noticeKey == 'privacy-policy-texts-outdated-notice')
        {
            SPDSGVOSettings::set('show_notice_privacy_policy_texts_outdated', '0');
        }

        if ($noticeKey == 'update-check-settings-notice')
        {
            SPDSGVOSettings::set('show_notice_update_check_settings', '0');
        }

        if ($noticeKey == 'update-notice-version-310')
        {
            SPDSGVOSettings::set('show_notice_update_310', '0');
        }

        if ($noticeKey == 'feature-notice-webinars')
        {
            SPDSGVOSettings::set('show_notice_webinars', '0');
        }

	    if ($noticeKey == 'update-notice-securityleak0921')
	    {
		    SPDSGVOSettings::set('show_notice_securityleak0921', '0');
	    }

        die;
    }
}

SPDSGVONoticeAction::listen();