<?php

Class SPDSGVOSuperUnsubscribeFormAction extends SPDSGVOAjaxAction{

    protected $action = 'super-unsubscribe';

    public function run(){

        if(!empty($_POST['website'])) die(); // anti spam honeypot

        $this->checkCSRF();

        if(!$this->has('email') || empty($this->get('email', NULL, 'sanitize_email'))){
            $this->error(__('Please enter an email address.','shapepress-dsgvo'));
        }
        
        if(!$this->has('dsgvo_checkbox') || $this->get('dsgvo_checkbox') !== '1'){
            $this->error(__('The GDPR approval is mandatory.','shapepress-dsgvo'));
        }

        $unsubscriber = SPDSGVOUnsubscriber::insert(array(
            'first_name' => $this->get('first_name'),
            'last_name'  => $this->get('last_name'),
            'email'      => $this->get('email', NULL, 'sanitize_email'),
            'process_now'=> $this->get('process_now'),
            'dsgvo_accepted' => $this->get('dsgvo_checkbox')
        ));

        if (SPDSGVOSettings::get('su_email_notification') === '1' 
            && SPDSGVOSettings::get('admin_email') !== ''
            && $this->has('process_now') == false)
        {
            // Send Email
            wp_mail(SPDSGVOSettings::get('admin_email'),
                __('New delete request','shapepress-dsgvo').': '. parse_url(home_url(), PHP_URL_HOST),
                __('A new subject access request from ','shapepress-dsgvo') .' '.$this->get('email')."' was made.");
        }
        
        if($this->has('process_now')){
            $unsubscriber->doSuperUnsubscribe();
        }

        if($this->has('is_admin')){
            $this->returnBack();
        }

        $superUnsubscribePage = SPDSGVOSettings::get('super_unsubscribe_page');
        if($superUnsubscribePage !== '0'){
            $url = get_permalink($superUnsubscribePage);
            $this->returnRedirect($url, array(
                'result' => 'success',
            ));
        }

        $this->returnBack();
    }
}

SPDSGVOSuperUnsubscribeFormAction::listen();
