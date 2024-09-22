<?php

Class SPDSGVOOperatorAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-operator';

    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();

        $textRefreshNeeded = $this->get('spdsgvo_company_info_countrycode', '') != SPDSGVOSettings::get('spdsgvo_company_info_countrycode');

        SPDSGVOSettings::set('page_operator_type', $this->get('page_operator_type', ''));
        SPDSGVOSettings::set('page_operator_corporate_name', $this->get('page_operator_corporate_name', ''));
        SPDSGVOSettings::set('page_operator_corporate_ceo', $this->get('page_operator_corporate_ceo', ''));

        SPDSGVOSettings::set('page_operator_corp_public_law_name', $this->get('page_operator_corp_public_law_name', ''));
        SPDSGVOSettings::set('page_operator_corp_public_law_supervisor', $this->get('page_operator_corp_public_law_supervisor', ''));
        SPDSGVOSettings::set('page_operator_corp_public_law_representative', $this->get('page_operator_corp_public_law_representative', ''));

        SPDSGVOSettings::set('page_operator_company_law_person', $this->get('page_operator_company_law_person', ''));
        SPDSGVOSettings::set('page_operator_company_name', $this->get('page_operator_company_name', ''));
        SPDSGVOSettings::set('page_operator_operator_name', $this->get('page_operator_operator_name', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_countrycode', $this->get('spdsgvo_company_info_countrycode', ''));

        SPDSGVOSettings::set('spdsgvo_company_info_street', $this->get('spdsgvo_company_info_street', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_loc', $this->get('spdsgvo_company_info_loc', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_zip', $this->get('spdsgvo_company_info_zip', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_countrycode', $this->get('spdsgvo_company_info_countrycode', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_phone', $this->get('spdsgvo_company_info_phone', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_email', $this->get('spdsgvo_company_info_email', '', 'sanitize_email'));

        SPDSGVOSettings::set('spdsgvo_company_fn_nr', $this->get('spdsgvo_company_fn_nr', ''));
        SPDSGVOSettings::set('spdsgvo_company_law_loc', $this->get('spdsgvo_company_law_loc', ''));
        SPDSGVOSettings::set('spdsgvo_company_uid_nr', $this->get('spdsgvo_company_uid_nr', ''));
        SPDSGVOSettings::set('spdsgvo_company_law_person', $this->get('spdsgvo_company_law_person', ''));
        SPDSGVOSettings::set('spdsgvo_company_chairmen', $this->get('spdsgvo_company_chairmen', ''));
        SPDSGVOSettings::set('spdsgvo_company_resp_content', $this->get('spdsgvo_company_resp_content', ''));

        SPDSGVOSettings::set('page_operator_society_name', $this->get('page_operator_society_name', ''));
        SPDSGVOSettings::set('page_operator_society_board', $this->get('page_operator_society_board', ''));
        SPDSGVOSettings::set('page_operator_society_number', $this->get('page_operator_society_number', ''));

        SPDSGVOSettings::set('page_operator_privacy_shield', $this->get('page_operator_privacy_shield', '0'));

        SPDSGVOSettings::set('operator_pp_responsibility_type', $this->get('operator_pp_responsibility_type', ''));
        SPDSGVOSettings::set('operator_pp_dso_intern_name', $this->get('operator_pp_dso_intern_name', ''));
        SPDSGVOSettings::set('operator_pp_dso_intern_phone', $this->get('operator_pp_dso_intern_phone', ''));
        SPDSGVOSettings::set('operator_pp_dso_intern_email', $this->get('operator_pp_dso_intern_email', '', 'sanitize_email'));

        SPDSGVOSettings::set('operator_pp_dso_external_company', $this->get('operator_pp_dso_external_company', ''));
        SPDSGVOSettings::set('operator_pp_dso_external_name', $this->get('operator_pp_dso_external_name', ''));
        SPDSGVOSettings::set('operator_pp_dso_external_street', $this->get('operator_pp_dso_external_street', ''));
        SPDSGVOSettings::set('operator_pp_dso_external_loc', $this->get('operator_pp_dso_external_loc', ''));
        SPDSGVOSettings::set('operator_pp_dso_external_zip', $this->get('operator_pp_dso_external_zip', ''));
        SPDSGVOSettings::set('operator_pp_dso_external_countrycode', $this->get('operator_pp_dso_external_countrycode', ''));
        SPDSGVOSettings::set('operator_pp_dso_external_phone', $this->get('operator_pp_dso_external_phone', ''));
        SPDSGVOSettings::set('operator_pp_dso_external_email', $this->get('operator_pp_dso_external_email', '', 'sanitize_email'));

        SPDSGVOSettings::set('operator_pp_responsibility_contact', $this->get('operator_pp_responsibility_contact', ''));
        SPDSGVOSettings::set('operator_pp_dso_contact_intern_name', $this->get('operator_pp_dso_contact_intern_name', ''));
        SPDSGVOSettings::set('operator_pp_dso_contact_intern_phone', $this->get('operator_pp_dso_contact_intern_phone', ''));
        SPDSGVOSettings::set('operator_pp_dso_contact_intern_email', $this->get('operator_pp_dso_contact_intern_email', '', 'sanitize_email'));

        SPDSGVOSettings::set('operator_pp_dso_contact_external_company', $this->get('operator_pp_dso_contact_external_company', ''));
        SPDSGVOSettings::set('operator_pp_dso_contact_external_name', $this->get('operator_pp_dso_contact_external_name', ''));
        SPDSGVOSettings::set('operator_pp_dso_contact_external_street', $this->get('operator_pp_dso_contact_external_street', ''));
        SPDSGVOSettings::set('operator_pp_dso_contact_external_loc', $this->get('operator_pp_dso_contact_external_loc', ''));
        SPDSGVOSettings::set('operator_pp_dso_contact_external_zip', $this->get('operator_pp_dso_contact_external_zip', ''));
        SPDSGVOSettings::set('operator_pp_dso_contact_external_countrycode', $this->get('operator_pp_dso_contact_external_countrycode', ''));
        SPDSGVOSettings::set('operator_pp_dso_contact_external_phone', $this->get('operator_pp_dso_contact_external_phone', ''));
        SPDSGVOSettings::set('operator_pp_dso_contact_external_email', $this->get('operator_pp_dso_contact_external_email', '', 'sanitize_email'));

        if ($textRefreshNeeded)
        {
            SPDSGVOSettings::set('show_notice_privacy_policy_texts_outdated', '1');
            try {
                SPDSGVOLanguageTools::updateLwTexts();
            } catch (Exception $e) {}
        }

        SPDSGVOCacheManager::clearCaches();
        $this->returnBack();
    }
}

SPDSGVOOperatorAction::listen();
