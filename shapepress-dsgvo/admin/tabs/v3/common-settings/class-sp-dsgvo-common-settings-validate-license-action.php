<?php

class SPDSGVOCommonSettingsValidateLicenseAction extends SPDSGVOAjaxAction
{

    protected $action = 'admin-common-settings-validate-license';

    protected function run()
    {
        $this->requireAdmin();
        error_log('admin-common-settings-validate-license');

        $licActivated = SPDSGVOSettings::get('license_activated');
        $licenceKey = SPDSGVOSettings::get('dsgvo_licence');
        $oldLicenseStatus = SPDSGVOSettings::get('licence_status');

        if ($licenceKey !== '' && SPDSGVOSettings::get('license_activated') === '1') {

            error_log('validating licence '.$licenceKey);
            $siteUrl = get_site_url();
            $homeUrl = get_home_url();

            $url = SPDSGVOConstants::LEGAL_WEB_BASE_URL .'/spdsgvo-bin/licensedetails.php';
            $url .= '?license_key=' .$licenceKey;
            $url .= '&site_url=' .$siteUrl;
            $url .= '&home_url=' .$homeUrl;

            $request = wp_remote_get($url);

            if( is_wp_error( $request ) ) {

                error_log(__('error during license validation: ', 'shapepress-dsgvo').$request->get_error_message()); // Bail early
            } else {

                $body = wp_remote_retrieve_body( $request );
                error_log('body: '.$body);

                if ($body != false && (strpos($body, 'INVALID_LICENCE_REQUEST') === false))
                {
                    SPDSGVOSettings::set('licence_details_fetched', '1');
                    SPDSGVOSettings::set('licence_details_fetched_new', '1');
                    SPDSGVOSettings::set('licence_details_fetched_on', date("D M d, Y G:i"));
                    SPDSGVOSettings::set('show_invalid_license_notice', '0');
                    SPDSGVOSettings::set('show_revoke_license_notice', '0');
                    
                    $data = json_decode( $body );
                    SPDSGVOSettings::set('licence_activated_on', $data->activation_date);
                    SPDSGVOSettings::set('licence_valid_to', $data->expiration_date);
                    SPDSGVOSettings::set('licence_number_use_remaining', $data->number_use_remaining);                   
                    SPDSGVOSettings::set('licence_status', $data->license_status);
                    
                    if (isPremiumEdition() && isLicenceValid() === false)
                    {
                        error_log("WP DSGVO Tools (GDPR) license is invalid.");
                        SPDSGVOSettings::set('show_invalid_license_notice', '1');
                    }
                    
                    if (licenseIsGoingToRunningOut())
                    {
                        error_log("WP DSGVO Tools (GDPR) license is going to running out in a few days");
                        SPDSGVOSettings::set('show_revoke_license_notice', '1');
                    }
                    
                    if (hasValidLicenseStatus($oldLicenseStatus, $licActivated)=== true
                        && hasValidLicenseStatus($data->license_status, $licActivated) === false)
                    {
                        error_log("WP DSGVO Tools (GDPR) license got invalid now. sending email to ".SPDSGVOSettings::get('admin_email'));
                        wp_mail(SPDSGVOSettings::get('admin_email'),
                            __('WP DSGVO Tools (GPDR) License Error','shapepress-dsgvo').': '. parse_url(home_url(), PHP_URL_HOST),
                            __('Your license has expired. Please renew it according to the hint at the plugin settings page.','shapepress-dsgvo'));
                    }
                }
            }
        }

        $this->returnBack();
    }
    
    public function doAction()
    {
        $this->run();
    }
}

SPDSGVOCommonSettingsValidateLicenseAction::listen();
