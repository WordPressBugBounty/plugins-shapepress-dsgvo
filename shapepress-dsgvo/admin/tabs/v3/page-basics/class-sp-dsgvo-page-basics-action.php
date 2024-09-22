<?php

Class SPDSGVOPageBasicsAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-page-basics';




    public static function getDefaultOtherText()
    {
        return __("<strong>Service:</strong> Name of the service<br /><strong>Operator:</strong> Company, address, state<br /><strong>Privacy Policy:</strong> Link Privacy Policy<br /><strong>Privacy Shield:</strong> Link Privacy Shield (only required with US service providers)<br />", 'shapepress-dsgvo');
    }


    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();

        SPDSGVOSettings::set('page_basics_hosting_provider', $this->get('page_basics_hosting_provider'));
        SPDSGVOSettings::set('page_basics_other_provider_text', $this->get('otherProviderText', NULL, 'wp_kses_post'));

        SPDSGVOSettings::set('page_basics_use_logfiles', $this->get('page_basics_use_logfiles'));
        SPDSGVOSettings::set('page_basics_logfiles_life', is_numeric($this->get('page_basics_logfiles_life')) ? $this->get('page_basics_logfiles_life') : '30');

        SPDSGVOSettings::set('page_basics_use_cdn', $this->get('page_basics_use_cdn'));
        SPDSGVOSettings::set('page_basics_cdn_provider', $this->get('page_basics_cdn_provider'));
        SPDSGVOSettings::set('page_basics_other_cdn_provider_text', $this->get('otherCdnProviderText', NULL, 'wp_kses_post'));

        SPDSGVOSettings::set('page_basics_use_payment_provider', $this->get('page_basics_use_payment_provider'));
        SPDSGVOSettings::set('page_basics_payment_provider', $this->get('page_basics_payment_provider'));

        SPDSGVOSettings::set('page_basics_font_provider', $this->get('page_basics_font_provider'));
        SPDSGVOSettings::set('page_basics_block_google_fonts', $this->get('page_basics_block_google_fonts'));


        SPDSGVOSettings::set('page_basics_forms_contact', $this->get('page_basics_forms_contact'));
        SPDSGVOSettings::set('page_basics_forms_application', $this->get('page_basics_forms_application'));
        SPDSGVOSettings::set('page_basics_forms_contest', $this->get('page_basics_forms_contest'));
        SPDSGVOSettings::set('page_basics_forms_registration', $this->get('page_basics_forms_registration'));
        SPDSGVOSettings::set('page_basics_forms_comments', $this->get('page_basics_forms_comments'));
        SPDSGVOSettings::set('page_basics_forms_comments_publish_type', $this->get('page_basics_forms_comments_publish_type'));

        SPDSGVOSettings::set('page_basics_security_provider', $this->get('page_basics_security_provider'));
        SPDSGVOSettings::set('page_basics_other_security_provider_text', $this->get('otherSecurityProviderText', NULL, 'wp_kses_post'));

        //SPDSGVOSettings::set('page_basics_embeddings', ''); // dont change this setting again. embeddings have their own settings now

        if (isValidPremiumEdition()) {
            SPDSGVOSettings::set('page_basics_use_newsletter_provider', $this->get('page_basics_use_newsletter_provider'));
            SPDSGVOSettings::set('page_basics_newsletter_provider', $this->get('page_basics_newsletter_provider'));
            SPDSGVOSettings::set('page_basics_other_newsletter_provider_text', $this->get('page_basics_other_newsletter_provider_text', NULL, 'wp_kses_post'));
        }


        $this->returnBack();
    }
}

SPDSGVOPageBasicsAction::listen();
