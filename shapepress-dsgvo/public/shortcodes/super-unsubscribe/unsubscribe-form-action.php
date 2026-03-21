<?php

Class SPDSGVOSuperUnsubscribeFormAction extends SPDSGVOAjaxAction{

    protected $action = 'super-unsubscribe';

    protected function notifyAdmin($email){
        if (SPDSGVOSettings::get('su_email_notification') !== '1' || SPDSGVOSettings::get('admin_email') === '') {
            return;
        }

        wp_mail(
            SPDSGVOSettings::get('admin_email'),
            __('New delete request','shapepress-dsgvo').': '. parse_url(home_url(), PHP_URL_HOST),
            __('A new delete request from ','shapepress-dsgvo') .' '. $email ."' was confirmed."
        );
    }

    public function run(){

        if(!empty($_POST['website'])) die(); // anti spam honeypot

        $this->checkCSRF();

	    $email = $this->get('email', null, 'sanitize_email');

	    if (!$email || !is_email($email)) {
		    $this->error(__('Please enter a valid email address.', 'shapepress-dsgvo'));
	    }
        
        if(!$this->has('dsgvo_checkbox') || $this->get('dsgvo_checkbox') !== '1'){
            $this->error(__('The GDPR approval is mandatory.','shapepress-dsgvo'));
        }

	    $is_admin_request = $this->has('process_now') && current_user_can('manage_options');
        $is_privileged_request = $this->has('is_admin') && current_user_can('manage_options');
        $requires_email_confirmation = !$is_privileged_request;

        $unsubscriber = SPDSGVOUnsubscriber::insert(array(
            'first_name' => $this->get('first_name'),
            'last_name'  => $this->get('last_name'),
            'email'      => $this->get('email', NULL, 'sanitize_email'),
            'process_now'=> $this->get('process_now'),
            'dsgvo_accepted' => $this->get('dsgvo_checkbox'),
            'status'     => $requires_email_confirmation ? 'unconfirmed' : 'pending',
        ));

        if ($is_privileged_request && $this->has('process_now') == false) {
            $this->notifyAdmin($email);
        }

	    if ($is_admin_request) {
		    $unsubscriber->doSuperUnsubscribe();
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
