<?php

Class SPDSGVOSubjectAccessRequestAction extends SPDSGVOAjaxAction{

    protected $action = 'subject-access-request';

    public function run(){

        if(!empty($_POST['website'])) die(); // anti spam honeypot

        $this->checkCSRF();

        if(!$this->has('email') || empty($this->get('email', NULL, 'sanitize_email'))){
            $this->error(__('Please enter an email address','shapepress-dsgvo'));
        }
        
        if(!$this->has('dsgvo_checkbox') || $this->get('dsgvo_checkbox') !== '1'){
            $this->error(__('The GDPR approval is mandatory.','shapepress-dsgvo'));
        }

        $sar = SPDSGVOSubjectAccessRequest::insert(array(
            'first_name' => $this->get('first_name'),
            'last_name'  => $this->get('last_name'),
            'email'      => $this->get('email', NULL, 'sanitize_email'),
            'dsgvo_accepted' => $this->get('dsgvo_checkbox')
        ));

        if (isValidPremiumEdition() == TRUE
            && SPDSGVOSettings::get('sar_email_notification') === '1'
            && SPDSGVOSettings::get('admin_email') !== ''
            && $this->has('process_now') == false) {
            // Send Email            
            wp_mail(SPDSGVOSettings::get('admin_email'), 
                __('New subject access request','shapepress-dsgvo').': '. parse_url(home_url(), PHP_URL_HOST), 
                __('A new subject access request from ','shapepress-dsgvo') .' '.$this->get('email')."' was made.");
        }

        if($this->has('process_now')){
            $displayEmail = ($this->get('display_email', '0') == '1');
            $sar->doSubjectAccessRequest($displayEmail);
        }

        if($this->has('is_admin')){
            $this->returnBack();
        }

        if($this->has('is_ajax')){
            echo wp_json_encode(array(
                'success'   => '1',
                'zip_link'  => SPDSGVODownloadSubjectAccessRequestAction::url(array(
                    'token'     => $sar->token,
                    'file'      => 'zip',
                )),
                'pdf_link'  => SPDSGVODownloadSubjectAccessRequestAction::url(array(
                    'token'     => $sar->token,
                    'file'      => 'pdf',
                )),
            ));
        }

        $SARPage = SPDSGVOSettings::get('sar_page');
        if($SARPage !== '0'){
            $url = get_permalink($SARPage);
            $this->returnRedirect($url, array(
                'result' => 'success',
            ));
        }

        $this->returnBack();
    }
}

SPDSGVOSubjectAccessRequestAction::listen();
