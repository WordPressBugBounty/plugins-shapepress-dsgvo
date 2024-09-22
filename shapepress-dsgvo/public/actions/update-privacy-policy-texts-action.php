<?php

Class SPDSGVOUpdatePrivacyPolicyTextsAction extends SPDSGVOAjaxAction{

    protected $action = 'update-privacy-policy-texts-action';

    protected function run(){

        if (empty(SPDSGVOLanguageTools::updateLwTexts()) == false) {
            SPDSGVOSettings::set('show_notice_privacy_policy_texts_outdated', '0');
        }

        die;
    }
}

SPDSGVOUpdatePrivacyPolicyTextsAction::listen();