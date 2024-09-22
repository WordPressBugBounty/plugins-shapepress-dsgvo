<?php


function SPDSGVOPrivacyPolicyShortcode($atts){

    $locale = SPDSGVOLanguageTools::getInstance()->getCurrentLanguageCode();
/*
    $params = shortcode_atts(array(
        'lang' => $locale
    ), $atts);

    $locale = $params['lang'];
*/
    $hTagTitle = "h1";
    $hTagSubtitle = "h2";
    $hTagSubSubtitle = "h3";


    $hTagTitle = SPDSGVOSettings::get('privacy_policy_title_html_htag');
    $hTagSubtitle = SPDSGVOSettings::get('privacy_policy_subtitle_html_htag');
    $hTagSubSubtitle = SPDSGVOSettings::get('privacy_policy_subsubtitle_html_htag');


    $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagTitle, SPDSGVOSettings::get('privacy_policy_custom_header'));
    //$privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Data protection','shapepress-dsgvo'));
    $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('privacy-policy-introduction', $locale));

    // <editor-fold desc="Responsible for data processing">
    $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Responsible','shapepress-dsgvo'));
    $responsibleText = SPDSGVOLanguageTools::getPrivacyPolicyText('content-person', $locale);
    // <p>The controller of your personal data on our website is:</p> {:50}, {:51}, {:52} {:53}, {:55}, {:54}.
    $operatorType = SPDSGVOSettings::get('page_operator_type');

    switch ($operatorType)
    {
        case 'private':
            $responsibleText .= SPDSGVOSettings::get('page_operator_operator_name') .", ";
            break;
        case 'one-man':
            $responsibleText .= SPDSGVOSettings::get('page_operator_company_law_person') .", ";
            $responsibleText .= SPDSGVOSettings::get('page_operator_company_name') .", ";
            break;
        case 'corporation':
            $responsibleText .= SPDSGVOSettings::get('page_operator_corporate_name') .", ";
            break;
        case 'society':
            $responsibleText .= SPDSGVOSettings::get('page_operator_society_name') .", ";
            break;
        case 'corp-public-law':
        case 'corp-private-law':
            $responsibleText .= SPDSGVOSettings::get('page_operator_corp_public_law_name') .", ";
            break;
    }

    $responsibleText .= SPDSGVOSettings::get('spdsgvo_company_info_street').", ";
    $responsibleText .= SPDSGVOSettings::get('spdsgvo_company_info_zip') . " ";
    $responsibleText .= SPDSGVOSettings::get('spdsgvo_company_info_loc') .", ";

	$countryCodeTemp = SPDSGVOSettings::get('spdsgvo_company_info_countrycode');
	if ($countryCodeTemp == "AT") $countryCodeTemp = "Österreich";
	if ($countryCodeTemp == "DE") $countryCodeTemp = "Deutschland";
	if ($countryCodeTemp == "CH") $countryCodeTemp = "Schweiz";
	if ($countryCodeTemp == "IT") $countryCodeTemp = "Italien";
    $responsibleText .= $countryCodeTemp .", ";
    if (empty(SPDSGVOSettings::get('spdsgvo_company_info_email')) == false)
        $responsibleText .= '<a href="mailto:' . SPDSGVOSettings::get('spdsgvo_company_info_email').'">'.SPDSGVOSettings::get("spdsgvo_company_info_email").'</a>' .", ";
    if (empty(SPDSGVOSettings::get('spdsgvo_company_info_phone')) == false) $responsibleText .= SPDSGVOSettings::get('spdsgvo_company_info_phone');

	$responsibleTextSeparator = apply_filters('spdsgvo_change_responsibleText_separator', ', ');
    if (empty($responsibleTextSepartor) !== false) $responsibleText = str_replace( ", ", $responsibleTextSeparator,$responsibleText);

    $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', $responsibleText);
    // </editor-fold>

    // 3rd party countries modification
    $countryCode =  strtolower(SPDSGVOSettings::get('spdsgvo_company_info_countrycode'));
    $supportedCountries = array('de','at');
    if (in_array($countryCode, $supportedCountries) == false) {
        // add special paragraph
        if ($countryCode == 'US') {
            // only show in us if privacy shield certed
            if (SPDSGVOSettings::get('page_operator_privacy_shield') == '1') {
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('privacy-policy-introduction-' . $countryCode, $locale));
            }
        } else {
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('privacy-policy-introduction-' . $countryCode, $locale));
        }
    }

    // <editor-fold desc="Data security officer">
    $operator_pp_responsibility_type = SPDSGVOSettings::get('operator_pp_responsibility_type');
    $dsoText = SPDSGVOLanguageTools::getPrivacyPolicyText('dso-responsible', $locale);
    // Unseren Datenschutzbeauftragten erreichen Sie unter:

    if ( $operator_pp_responsibility_type == 'external')
    {
        $dsoText .= SPDSGVOSettings::get('operator_pp_dso_external_company') .", ";
        $dsoText .= __('attn.','shapepress-dsgvo') . ' ' . SPDSGVOSettings::get('operator_pp_dso_external_name') .", <br />";
        $dsoText .=  SPDSGVOSettings::get('operator_pp_dso_external_street') ." <br />";
        $dsoText .=  SPDSGVOSettings::get('operator_pp_dso_external_zip') ." ";
        $dsoText .=  SPDSGVOSettings::get('operator_pp_dso_external_loc') ." <br />";
        $dsoText .= __('Phone:','shapepress-dsgvo') . ' ' . SPDSGVOSettings::get('operator_pp_dso_external_phone') ." <br />";
        $dsoText .= __('Email:','shapepress-dsgvo') . ' <a href= "mailto:' . SPDSGVOSettings::get('operator_pp_dso_external_email').'">'.SPDSGVOSettings::get("operator_pp_dso_external_email").'</a>' ." <br />";

    } elseif ($operator_pp_responsibility_type == 'internal')
    {
        $dsoText .= __('attn.','shapepress-dsgvo') . ' ' . SPDSGVOSettings::get('operator_pp_dso_intern_name') .", <br />";
        $dsoText .=  SPDSGVOSettings::get('spdsgvo_company_info_street') ." <br />";
        $dsoText .=  SPDSGVOSettings::get('spdsgvo_company_info_zip') ." ";
        $dsoText .=  SPDSGVOSettings::get('spdsgvo_company_info_loc') ." <br />";
        $dsoText .= __('Phone:','shapepress-dsgvo') . ' ' . SPDSGVOSettings::get('operator_pp_dso_intern_phone') ." <br />";
        $dsoText .= __('Email:','shapepress-dsgvo') . ' <a href= "mailto:' . SPDSGVOSettings::get('operator_pp_dso_intern_email').'">'.SPDSGVOSettings::get("operator_pp_dso_intern_email").'</a>' ." <br />";
    }

    // only add if not none
    if ($operator_pp_responsibility_type == 'external' || $operator_pp_responsibility_type == 'internal')
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Data security officer','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', $dsoText);
    }
    // </editor-fold>

    // <editor-fold desc="Responsible person for data security questions">
    if ($operator_pp_responsibility_type == 'no') {
        $operator_pp_responsibility_contact = SPDSGVOSettings::get('operator_pp_responsibility_contact');
        $dpqText = SPDSGVOLanguageTools::getPrivacyPolicyText('data-protection-responsible', $locale);
        // Unseren Ansprechpartner für Datenschutzangelegenheiten erreichen Sie unter:
        if ($operator_pp_responsibility_contact == 'external') {
            $dpqText .= SPDSGVOSettings::get('operator_pp_dso_contact_external_company') . ", ";
            $dpqText .= __('attn.', 'shapepress-dsgvo') . ' ' . SPDSGVOSettings::get('operator_pp_dso_contact_external_name') . ", <br />";
            $dpqText .= SPDSGVOSettings::get('operator_pp_dso_contact_external_street') . " <br />";
            $dpqText .= SPDSGVOSettings::get('operator_pp_dso_contact_external_loc') . " ";
            $dpqText .= SPDSGVOSettings::get('operator_pp_dso_contact_external_zip') . " <br />";
            $dpqText .= __('Phone:', 'shapepress-dsgvo') . ' ' . SPDSGVOSettings::get('operator_pp_dso_contact_external_phone') . " <br />";
            $dpqText .= __('Email:', 'shapepress-dsgvo') . ' <a href= "mailto:' . SPDSGVOSettings::get('operator_pp_dso_contact_external_email') . '">' . SPDSGVOSettings::get("operator_pp_dso_contact_external_email") . '</a>' . " <br />";
        } elseif ($operator_pp_responsibility_contact == 'internal') {
            $dpqText .= SPDSGVOSettings::get('spdsgvo_company_info_name') . " <br />";
            $dpqText .= __('attn.', 'shapepress-dsgvo') . ' ' . SPDSGVOSettings::get('operator_pp_dso_contact_intern_name') . ", <br />";
            $dpqText .= SPDSGVOSettings::get('spdsgvo_company_info_street') . " <br />";
            $dpqText .= SPDSGVOSettings::get('spdsgvo_company_info_zip') . " ";
            $dpqText .= SPDSGVOSettings::get('spdsgvo_company_info_loc') . " <br />";
            $dpqText .= __('Phone:', 'shapepress-dsgvo') . ' ' . SPDSGVOSettings::get('operator_pp_dso_contact_intern_phone') . " <br />";
            $dpqText .= __('Email:', 'shapepress-dsgvo') . ' <a href= "mailto:' . SPDSGVOSettings::get('operator_pp_dso_contact_intern_email') . '">' . SPDSGVOSettings::get("operator_pp_dso_contact_intern_email") . '</a>' . " <br />";
        }

        if ($operator_pp_responsibility_contact == 'external' || $operator_pp_responsibility_contact == 'internal') {
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Responsible for privacy issues', 'shapepress-dsgvo'));
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', $dpqText);
        }
    }
    // </editor-fold>

    // <editor-fold desc="Hosting">
    $selectedHostingProvider = SPDSGVOSettings::get('page_basics_hosting_provider');
    if (empty($selectedHostingProvider) == false) {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Hosting', 'shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('hosting-introduction', $locale));


        foreach (SPDSGVOConstants::getHostingProvider() as $key => $value) {

            if ($key == 'other') continue;

            if (in_array($key, $selectedHostingProvider)) {
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, $value);
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText($key, $locale));
            }
        }

        if (in_array('other', $selectedHostingProvider)) {
            //$privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, __('Hosting Provider', 'shapepress-dsgvo'));
            //$privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('other-hosting', $locale));
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOSettings::get('page_basics_other_provider_text'));
        }
    }
    // </editor-fold>

    // <editor-fold desc="Server Logfiles">
    $useLogFiles = SPDSGVOSettings::get('page_basics_use_logfiles');
    if ($useLogFiles == '1')
    {
        $logFileText = SPDSGVOLanguageTools::getPrivacyPolicyText('server-log-files', $locale);
        $logFileDays = SPDSGVOSettings::get('page_basics_logfiles_life');
        $logFileText = str_replace('{COUNT_DAYS}', $logFileDays, $logFileText);

        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Server Log Files','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('span', $logFileText);
    }

    // </editor-fold>

    // <editor-fold desc="CDN">
    $useCdnProvider = SPDSGVOSettings::get('page_basics_use_cdn');
    if ($useCdnProvider == '1')
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('CDN Provider','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('cdn-introduction', $locale));

        $selectedCdnProvider = SPDSGVOSettings::get('page_basics_cdn_provider');
        $selectedCdnProvider = is_array($selectedCdnProvider) ? $selectedCdnProvider : [] ;
        foreach (SPDSGVOConstants::getCDNServers() as $key => $value)
        {
            if ($key == 'other') continue;

            if (in_array($key, $selectedCdnProvider))
            {
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, $value);
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText($key, $locale));
            }
        }

        if (in_array('other', $selectedCdnProvider))
        {
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, __('CDN Provider','shapepress-dsgvo'));
            //$privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('other-cdn', $locale));
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOSettings::get('page_basics_other_cdn_provider_text'));
        }
    }

    // </editor-fold>

    // <editor-fold desc="Formulare">
    if (SPDSGVOSettings::get('page_basics_forms_contact') == '1')
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle,  __('Contact Form','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('contact-form', $locale));
    }
    if (SPDSGVOSettings::get('page_basics_forms_application') == '1')
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle,  __('Application Form','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('application-form', $locale));
    }
    if (SPDSGVOSettings::get('page_basics_forms_contest') == '1')
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Promotional contest or game form','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('contest-form', $locale));
    }
    if (SPDSGVOSettings::get('page_basics_forms_registration') == '1')
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Registration Form','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('registration-form', $locale));
    }
    if (SPDSGVOSettings::get('page_basics_forms_comments') == '1')
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Comments Form','shapepress-dsgvo'));
        //$privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('comments-form', $locale));

        $publishType = SPDSGVOSettings::get('page_basics_forms_comments_publish_type');
        if ($publishType = 'name_comment')
        {
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('comments-form-name', $locale));
        } elseif ($publishType = 'nick_comment')
        {
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('comments-form-nick', $locale));
        }
    }
    // </editor-fold>

    // <editor-fold desc="Security Services / Captcha">
    $selectedSecurityServices = SPDSGVOSettings::get('page_basics_security_provider');
    if (empty($selectedSecurityServices) == false)
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Security Services','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('security-services-introduction', $locale));

        foreach (SPDSGVOConstants::getSecurityServices() as $key => $value)
        {
            if ($key == 'local-security-question') continue;
            if ($key == 'other') continue;

            if (in_array($key, $selectedSecurityServices))
            {
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, $value);
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText($key, $locale));
            }
        }

        if (in_array('other', $selectedSecurityServices))
        {
            //$privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('other-security-service', $locale));
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOSettings::get('page_basics_other_security_provider_text'));
        }
    }
    // </editor-fold>

    // todo: Kartendienste

    // todo: Chat

    // <editor-fold desc="Fonts">
    $selectedFontProvider = SPDSGVOSettings::get('page_basics_font_provider');
    if (empty($selectedFontProvider) == false)
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Web Fonts','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('webfonts-introduction', $locale));

        foreach (SPDSGVOConstants::getFontServices() as $key => $value)
        {
            if (in_array($key, $selectedFontProvider))
            {
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, $value);
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText($key, $locale));
            }
        }
    }
    // </editor-fold>


    // <editor-fold desc="Embeddings">
    $integrations = SPDSGVOIntegrationApiBase::getAllIntegrationApis(SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS, FALSE);
    $enabledIntegrationCount = 0;
    $integrationTexts = null;
    foreach ($integrations as $integrationSlug => $integration)
    {
        if ($integration->getIsEnabled())
        {
            $enabledIntegrationCount += 1;
            $integrationTexts[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, $integration->getName());
            $integrationTexts[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText($integrationSlug, $locale));
        }
    }
    if ($enabledIntegrationCount > 0)
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Embeddings','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText(SPDSGVOConstants::CATEGORY_SLUG_EMBEDDINGS.'-introduction', $locale));

        $privacyPolicy = array_merge($privacyPolicy, $integrationTexts);
    }
    // </editor-fold>

    // <editor-fold desc="Shop">
    // todo: check wegen bestellung als gast
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Web Shop','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('webshop-introduction', $locale));

    }
    // </editor-fold>
    // <editor-fold desc="Payment Provider">
    if (SPDSGVOSettings::get('page_basics_use_payment_provider') == '1')
    {
        $enabled_gateways = SPDSGVOSettings::get('page_basics_payment_provider');
        $enabled_gateways = is_array($enabled_gateways) ? $enabled_gateways : [] ;
        $dummyProvider = array('cash', 'cod','bank-transfer');

        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, __('Payments are processed via:','shapepress-dsgvo'));
        foreach ($enabled_gateways as $gateway)
        {
            if (in_array($gateway, $dummyProvider)) continue;
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText($gateway, $locale));

        }
    }

    // </editor-fold>

    // <editor-fold desc="Tagmanager">
    $integrations = SPDSGVOIntegrationApiBase::getAllIntegrationApis(SPDSGVOConstants::CATEGORY_SLUG_TAGMANAGER, FALSE);
    $enabledIntegrationCount = 0;
    $integrationTexts = null;
    foreach ($integrations as $integrationSlug => $integration)
    {
        if ($integration->getIsEnabled())
        {
            $enabledIntegrationCount += 1;
            $integrationTexts[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, $integration->getName());
            $integrationTexts[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText($integrationSlug, $locale));
        }
    }
    if ($enabledIntegrationCount > 0)
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Tag Manager','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText(SPDSGVOConstants::CATEGORY_SLUG_TAGMANAGER.'-introduction', $locale));

        $privacyPolicy = array_merge($privacyPolicy, $integrationTexts);
    }
    // </editor-fold>

    // <editor-fold desc="Analyse">
    $integrations = SPDSGVOIntegrationApiBase::getAllIntegrationApis(SPDSGVOConstants::CATEGORY_SLUG_STATISTICS, FALSE);

    // add techn. required too (wp stats, matomo, piwik, mautic) because the have another catin the filter
    if (SPDSGVOMatomoApi::getInstance()->getIsEnabled()) $integrations[SPDSGVOMatomoApi::getInstance()->getSlug()] =SPDSGVOMatomoApi::getInstance();
    if (SPDSGVOWpStatisticsApi::getInstance()->getIsEnabled()) $integrations[SPDSGVOWpStatisticsApi::getInstance()->getSlug()] = SPDSGVOWpStatisticsApi::getInstance();
    if (SPDSGVOPiwikApi::getInstance()->getIsEnabled()) $integrations[SPDSGVOPiwikApi::getInstance()->getSlug()] = SPDSGVOPiwikApi::getInstance();
    if (SPDSGVOMauticApi::getInstance()->getIsEnabled()) $integrations[SPDSGVOMauticApi::getInstance()->getSlug()] = SPDSGVOMauticApi::getInstance();

    $enabledIntegrationCount = 0;
    $integrationTexts = null;
    foreach ($integrations as $integrationSlug => $integration)
    {

        if ($integration->getIsEnabled())
        {
            $integrationSettings = $integration->getSettings();
            $ppSlugName = $integrationSlug;
            if (array_key_exists('implementationMode',$integrationSettings) && empty($integrationSettings['implementationMode']) == false)
            {
                $ppSlugName .= '-'.$integrationSettings['implementationMode'];
            }

            $enabledIntegrationCount += 1;
            $integrationTexts[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, $integration->getName());

            // do replacings for matomo and piwik
            $webAgencyText = "";
            if (array_key_exists('agency', $integrationSettings['meta']) == true)
            {
                $webAgencyText = $integrationSettings['meta']['agency'];
            }
            $ppText = SPDSGVOLanguageTools::getPrivacyPolicyText($ppSlugName, $locale);
            if (strpos($ppSlugName, "by-agency") >= 0)
            {
                $ppText = str_replace("{web_agency}", $webAgencyText, $ppText);
            }

            $integrationTexts[] = SPDSGVOGetFormatedHtmlTextArray('p', $ppText);
        }
    }
    if ($enabledIntegrationCount > 0)
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Analysis Services','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText(SPDSGVOConstants::CATEGORY_SLUG_STATISTICS.'-introduction', $locale));
        $privacyPolicy = array_merge($privacyPolicy, $integrationTexts);
    }
    // </editor-fold>

    // <editor-fold desc="Targeting">
    $integrations = SPDSGVOIntegrationApiBase::getAllIntegrationApis(SPDSGVOConstants::CATEGORY_SLUG_TARGETING, FALSE);
    $enabledIntegrationCount = 0;
    $integrationTexts = null;
    foreach ($integrations as $integrationSlug => $integration)
    {
        if ($integration->getIsEnabled())
        {
            $enabledIntegrationCount += 1;
            $integrationTexts[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, $integration->getName());
            $integrationTexts[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText($integrationSlug, $locale));
        }
    }
    if ($enabledIntegrationCount > 0)
    {
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Ads, Profiling, Tracking, Retargeting','shapepress-dsgvo'));
        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText(SPDSGVOConstants::CATEGORY_SLUG_TARGETING.'-introduction', $locale));

        $privacyPolicy = array_merge($privacyPolicy, $integrationTexts);
    }
    // </editor-fold>

    // <editor-fold desc="Newsletter">
    if (SPDSGVOSettings::get('page_basics_use_newsletter_provider') == '1')
    {
        $enabled_newsletter = SPDSGVOSettings::get('page_basics_newsletter_provider');
        $enabled_newsletter = is_array($enabled_newsletter) ? $enabled_newsletter : [] ;
        $dummyProvider = array('own');

        $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Newsletter Services','shapepress-dsgvo'));

        foreach (SPDSGVOConstants::getNewsletterIntegrations() as $key => $value)
        {
            if ($key == 'other') continue;

            if (in_array($key, $enabled_newsletter))
            {
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, $value);
                $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText($key, $locale));
            }
        }

        if (in_array('other', $enabled_newsletter))
        {
            //$privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubSubtitle, __('Newsletter Service','shapepress-dsgvo'));
            $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOSettings::get('page_basics_other_newsletter_provider_text'));
        }

    }

    // here the affected rights start
    // <editor-fold desc="Widerspruchsrecht">
    $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Right to object','shapepress-dsgvo'));
    $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('right-to-object', $locale));
    // </editor-fold>

    // <editor-fold desc="Widerrufsrecht">
    $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Withdrawal','shapepress-dsgvo'));
    $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('right-to-withdrawal', $locale));
    // </editor-fold>

    // <editor-fold desc="Widerrufsrecht">
    $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray($hTagSubtitle, __('Right to data subject','shapepress-dsgvo'));
    $privacyPolicy[] = SPDSGVOGetFormatedHtmlTextArray('p', SPDSGVOLanguageTools::getPrivacyPolicyText('right-to-data-subject', $locale));
    // </editor-fold>


    /*
    $privacyPolicyPage = SPDSGVOSettings::get('privacy_policy_page');

    if(get_post($privacyPolicyPage) instanceof WP_POST) {
        $privacyPolicy = str_replace('[save_date]', date('d.m.Y H:i',strtotime(get_post($privacyPolicyPage)->post_modified)), $privacyPolicy);
    }
    */

    $htmlContent = '';
    foreach ($privacyPolicy as $lineItem)
    {
        if (!empty($lineItem['text'])) {
            $htmlContent .= SPDSGVOGetHtmlFromPrivacyPolicyLineItem($lineItem);
        }
    }

    return apply_filters('the_content', wp_kses_post($htmlContent));
}

add_shortcode('privacy_policy', 'SPDSGVOPrivacyPolicyShortcode');

