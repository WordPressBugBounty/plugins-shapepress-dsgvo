<?php

class SPDSGVOCommonSettingsActivateAction extends SPDSGVOAjaxAction
{

    protected $action = 'admin-common-settings-activate';

    protected function run()
    {
        $this->requireAdmin();

        $oldLicenceKey = SPDSGVOSettings::get('dsgvo_licence');
        $licenceKey = $this->get('dsgvo_licence', '');
        if (empty($licenceKey) == false) $licenceKey = trim($licenceKey);

        if (SPDSGVOSettings::get('license_activated') === '0')
        {
            $siteUrl = get_site_url();
            $homeUrl = get_home_url();

            //error_log('activating licence '.$licenceKey);
            SPDSGVOSettings::set('license_activated', '0');
            SPDSGVOSettings::set('license_key_error', '1');

            $url = SPDSGVOConstants::LEGAL_WEB_BASE_URL .'/spdsgvo-bin/activate.php';
            $url .= '?license_key=' .$licenceKey;
            $url .= '&site_url=' .$siteUrl;
            $url .= '&home_url=' .$homeUrl;

            $request = wp_remote_get($url);

            if( is_wp_error( $request ) ) {

                error_log(__('error during license activation: ', 'shapepress-dsgvo') . $request->get_error_message()); // Bail early
            } else {
                $result = wp_remote_retrieve_body( $request );
                if (strpos($result, 'OK') !== false) {
                    SPDSGVOSettings::set('license_key_error', '0');
                    SPDSGVOSettings::set('license_activated', '1');
                } else
                {
                    SPDSGVOSettings::set('license_activation_error', $result);
                    SPDSGVOSettings::set('license_key_error', '1');
                }

            }
        } elseif(SPDSGVOSettings::get('license_activated') === '1')
        {
            $licenceKey = SPDSGVOSettings::get('dsgvo_licence'); // get the key from storage although its a readonly field
            $url = 'https://legalweb.io/spdsgvo-bin/deactivate.php';
            $url .= '?license_key=' .$licenceKey;

            $request = wp_remote_get($url);

            if( is_wp_error( $request ) ) {

                error_log(__('error during license activation: ', 'shapepress-dsgvo').$request->get_error_message()); // Bail early
            } else {
                $result = wp_remote_retrieve_body( $request );
                if (strpos($result, 'OK') !== false) {
                    SPDSGVOSettings::set('license_key_error', '1');
                    SPDSGVOSettings::set('license_activated', '0');
                    SPDSGVOSettings::set('licence_valid_to', '');
                    SPDSGVOSettings::set('licence_activated_on', '');
                    SPDSGVOSettings::set('dsgvo_licence','');
                    $licenceKey = '';
                } else
                {

                }
            }
        }


        if ($licenceKey !== '' && SPDSGVOSettings::get('license_activated') === '1') {

            //error_log('validating licence '.$licenceKey);

            $url = 'https://legalweb.io/spdsgvo-bin/licensedetails.php';
            $url .= '?license_key=' .$licenceKey;

            $request = wp_remote_get($url);

            if( is_wp_error( $request ) ) {

                error_log(__('error during license details: ', 'shapepress-dsgvo').$request->get_error_message()); // Bail early
            } else {

                $body = wp_remote_retrieve_body( $request );

                if ($body !== false)
                {
                    if ($body !== false)
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
                        
                        if (isPremiumEdition() && (new DateTime($data->expiration_date)) < (new DateTime()))
                        {
                            SPDSGVOSettings::set('show_invalid_license_notice', '1');
                        }
                        
                        if (isPremiumEdition() && (new DateTime($data->expiration_date)) <= (new DateTime('today -14 days')))
                        {
                            SPDSGVOSettings::set('show_revoke_license_notice', '1');
                        }
                    }
                }
            }
        }

        SPDSGVOSettings::set('dsgvo_licence', $licenceKey);

        $this->returnBack();
    }
}

SPDSGVOCommonSettingsActivateAction::listen();
