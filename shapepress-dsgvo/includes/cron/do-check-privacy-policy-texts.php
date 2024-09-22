<?php

Class DoCheckPrivacyPolicyTexts extends SPDSGVOCron
{

    public $interval = array(
        'days' => 2,
    );

    public function handle()
    {
        $localTextsLanguage = SPDSGVOSettings::get('legal_web_texts_lang');
        $localTextsVersion = SPDSGVOSettings::get('legal_web_texts_version');
        $localTextsLastUpdate = SPDSGVOSettings::get('legal_web_texts_last_update');


        $url = SPDSGVOConstants::LEGAL_WEB_TEXT_SERVICE_URL;
        $url .= '?lang=' . $localTextsLanguage;
        $url .= '&version=' . $localTextsVersion;
        $url .= '&apiVersion=' . SPDSGVOConstants::LEGAL_WEB_TEXT_SERVICE_VERSION;

        $msgText = __('Attention. There are newer texts for the privacy policy. Please refresh them ensure compliance. Click <a href="ADMIN_URL" target="_blank"> here</a> to access your page and refresh them manually by clicking the button "Reload Privacy Policy texts".', 'shapepress-dsgvo');
        $msgText = str_replace("ADMIN_URL",get_admin_url()."admin.php?page=sp-dsgvo",$msgText);

        $request = wp_remote_get($url);
        if (is_wp_error($request)) {
            $error_string = $request->get_error_message();
            error_log(__('error while updating language texts: ', 'shapepress-dsgvo') . $error_string); // Bail early
        } else {

            SPDSGVOSettings::set('legal_web_texts_last_check', time());

            $result = wp_remote_retrieve_body($request);
            if (strpos($result, "INFO") === 0) {
                // file actual, just do nothing
            } elseif (empty($result) == false && strpos($result, "ERROR") !== 0) {
                // if premium then update texts, otherwise bring a notice

                $resultCleaned = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $result);

                // try to create json. if success then store
                $xmlTextsJson = json_decode($resultCleaned, true);

                if ($xmlTextsJson != null) {

                    $version = $xmlTextsJson['Version'];
                    SPDSGVOSettings::set('legal_web_texts_remote_version', $version);

                    // if premium then update texts, otherwise bring a notice
                    if (isValidPremiumEdition() == false) {
                        SPDSGVOSettings::set('show_notice_privacy_policy_texts_outdated', '1');

                        if (SPDSGVOSettings::get('pp_texts_notification_mail') == '1' &&
                            SPDSGVOSettings::get('legal_web_texts_remote_version_email_sent') != $version) {

                            /*
                            $locale = SPDSGVOLanguageTools::getInstance()->getCurrentLanguageCode();

                            $email = SPDSGVOMail::init()
                                ->from(SPDSGVOSettings::get('admin_email'))
                                ->to(SPDSGVOSettings::get('admin_email'))
                                ->subject(__('WP DSGVO Tools (GPDR) Privacy policy texts outdated', 'shapepress-dsgvo') . ': ' . parse_url(home_url(), PHP_URL_HOST))
                                ->template(SPDSGVO::pluginDir('/templates/'.$locale.'/emails/legal-texts-update.php'), array(
                                    'website' 		=> parse_url(home_url(), PHP_URL_HOST),
                                    'home_url' 		=> home_url(),
                                ))
                                ->send();
*/
                            $msgText = __('Attention. There are newer texts for the privacy policy. Please refresh them ensure compliance. Click <a href="ADMIN_URL" target="_blank"> here</a> to access your page and refresh them manually by clicking the button "Reload Privacy Policy texts".', 'shapepress-dsgvo');
                            $msgText =  str_replace("ADMIN_URL",get_admin_url()."admin.php?page=sp-dsgvo",$msgText);

                            wp_mail(SPDSGVOSettings::get('admin_email'),
                                __('WP DSGVO Tools (GPDR) Privacy policy texts outdated', 'shapepress-dsgvo') . ': ' . parse_url(home_url(), PHP_URL_HOST),
                                $msgText);

                            SPDSGVOSettings::set('legal_web_texts_remote_version_email_sent', $version);
                        }
                        return;
                    }

                    $xmlTextsBase64 = base64_encode($xmlTextsJson['Texts']);

                    if ($version == null || $version == '') $version = time();

                    SPDSGVOSettings::set('legal_web_texts', $xmlTextsBase64);
                    SPDSGVOSettings::set('legal_web_texts_version', $version);
                    SPDSGVOSettings::set('legal_web_texts_lang', $localTextsLanguage);
                    SPDSGVOSettings::set('legal_web_texts_last_update', time());

                    return $xmlTextsBase64;
                } else {
                    $jsonError = json_last_error();
                    error_log('wrong texts received. json_error: ' . $jsonError); // Bail early
                }

            } else {
                error_log('ERROR: shapepress-dsgvo: DoCheckPrivacyPolicyTexts: ' . $result);
            }
        }

    }
}

DoCheckPrivacyPolicyTexts::register();
