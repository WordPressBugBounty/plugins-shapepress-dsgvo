<?php

function SPDSGVOImprintShortcode($atts){

    $locale = SPDSGVOLanguageTools::getInstance()->getCurrentLanguageCode();
/*
    $params = shortcode_atts(array(
        'lang' => $locale
    ), $atts);

    $locale = $params['lang'];
*/
    $settings = SPDSGVOSettings::getAll();


    $operatorType = $settings['page_operator_type'];
    $selectedCountry = $settings['spdsgvo_company_info_countrycode'];
    $selectedCountry = SPDSGVOConstants::getCountries()[$selectedCountry];
    $selectedCountry = __($selectedCountry, 'shapepress-dsgvo');

    $owner = "";
    $companyName = "";
    switch ($operatorType) {
        case 'private':
            $companyName = '';
            $owner = $settings['page_operator_operator_name'];

            $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $owner);
            break;
        case 'one-man':
            $companyName = $settings['page_operator_company_name'];
            $owner = __('Company owner','shapepress-dsgvo'). ": " . $settings['page_operator_company_law_person'];

            $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $companyName);
            $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $owner);
            break;
        case 'corporation':
            $companyName = $settings['page_operator_corporate_name'];
            $owner = __('Executive director','shapepress-dsgvo'). ": " .$settings['page_operator_corporate_ceo'] ;

            $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $companyName);
            if (empty($settings['page_operator_corporate_ceo']) == false) $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $owner);
            break;
        case 'society':
            $societyName = $settings['page_operator_society_name'];
            $board = __('Simplifying board','shapepress-dsgvo'). ": " .$settings['page_operator_society_board'] ;

            $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $societyName);
            if (empty($settings['page_operator_society_board']) == false) $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $board);
            break;
        case 'corp-public-law' :
        case 'corp-private-law' :

            $companyName =  $settings['page_operator_corp_public_law_name'];
            $representative =  $settings['page_operator_corp_public_law_representative'];
            $supervisor =  $settings['page_operator_corp_public_law_supervisor'];

            if (empty($companyName) == false) $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $companyName);
            if (empty($representative) == false)  {
                $imprint[] =  SPDSGVOGetFormatedHtmlTextArray('br', __('Representative person','shapepress-dsgvo'). ': '. $representative);
            }
            if (empty($supervisor) == false) {
                $imprint[] =  SPDSGVOGetFormatedHtmlTextArray('br', __('Supervisory authority','shapepress-dsgvo'). ': '. $supervisor);
            }
            break;
    }

    $selectedCountry = $settings['spdsgvo_company_info_countrycode'];
    $selectedCountry = SPDSGVOConstants::getCountries()[$selectedCountry];
    $selectedCountry = __($selectedCountry, 'shapepress-dsgvo');

    $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $settings['spdsgvo_company_info_street']);
    $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $settings['spdsgvo_company_info_zip'] . " " . $settings['spdsgvo_company_info_loc']);
    $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', $selectedCountry);
    $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('Email', 'shapepress-dsgvo'). ': <a href="mailto:' . $settings['spdsgvo_company_info_email'] .'">'.$settings['spdsgvo_company_info_email'].'</a>');
    $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('Phone', 'shapepress-dsgvo'). ": " .$settings['spdsgvo_company_info_phone']);

    switch ($operatorType) {
        case 'private':

            break;
        case 'one-man':
            if (empty($settings['spdsgvo_company_uid_nr']) == false)
            {
                $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('Sales tax identification number','shapepress-dsgvo'). ": ".$settings['spdsgvo_company_uid_nr']);
            }
            if (empty($settings['spdsgvo_company_fn_nr']) == false)
            {
                $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('Commercial book no.','shapepress-dsgvo'). ": ".$settings['spdsgvo_company_fn_nr']);
            }
            if (empty($settings['spdsgvo_company_law_loc']) == false)
            {
                $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('§11 Place of Jurisdiction','shapepress-dsgvo'). ": ".$settings['spdsgvo_company_law_loc']);
            }
            break;
        case 'corporation':

            $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('Shareholder','shapepress-dsgvo'). ": ".$settings['spdsgvo_company_chairmen']);
            $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('Register Court & Register Number','shapepress-dsgvo'). ": ".$settings['spdsgvo_company_law_loc'] . " ". $settings['spdsgvo_company_fn_nr']);
            if (empty($settings['spdsgvo_company_uid_nr']) == false)
            {
                $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('Sales tax identification number','shapepress-dsgvo'). ": ".$settings['spdsgvo_company_uid_nr']);
            }
            break;
        case 'society':
            if (empty($settings['page_operator_society_number']) == false)
            {
                $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('Society number','shapepress-dsgvo'). ": ".$settings['page_operator_society_number']);
            }
            if (empty($settings['spdsgvo_company_uid_nr']) == false)
            {
                $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('Sales tax identification number','shapepress-dsgvo'). ": ".$settings['spdsgvo_company_uid_nr']);
            }
            if (empty($settings['spdsgvo_company_fn_nr']) == false)
            {
                $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('Commercial book no.','shapepress-dsgvo'). ": ".$settings['spdsgvo_company_fn_nr']);
            }
            if (empty($settings['spdsgvo_company_law_loc']) == false)
            {
                $imprint[] = SPDSGVOGetFormatedHtmlTextArray('br', __('§11 Place of Jurisdiction','shapepress-dsgvo'). ": ".$settings['spdsgvo_company_law_loc']);
            }
            break;
    }

    $imprint[] = SPDSGVOGetFormatedHtmlTextArray('p', __('Responsible for content','shapepress-dsgvo'). ": ".$settings['spdsgvo_company_resp_content']);

    $imprint[] = SPDSGVOGetFormatedHtmlTextArray('p', __('European Commission Online Dispute Resolution (OS) platform for consumers: <a href="https://ec.europa.eu/consumers/odr/" target="_blank">https://ec.europa.eu/consumers/odr/</a>. We are not willing or obliged to participate in a dispute settlement procedure before a consumer arbitration board.','shapepress-dsgvo'));

   // $imprint[] = SPDSGVOGetFormatedHtmlTextArray('p', __('','shapepress-dsgvo'). ": ".$settings['']);

    //$imprintPage = SPDSGVOSettings::get('imprint_page');
    
    //$imprint = str_replace('[save_date]', date('d.m.Y H:i',strtotime(get_post($imprintPage)->post_modified)), $imprint);


    $htmlContent = '';
    foreach ($imprint as $lineItem)
    {
        if (!empty($lineItem['text'])) {
            $htmlContent .= SPDSGVOGetHtmlFromPrivacyPolicyLineItem($lineItem);
        }
    }


    return apply_filters('the_content', wp_kses_post($htmlContent));
}

add_shortcode('imprint', 'SPDSGVOImprintShortcode');
