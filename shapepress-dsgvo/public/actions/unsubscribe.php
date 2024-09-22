<?php

Class SPDSGVOUnsubscribeAction extends SPDSGVOAjaxAction{

    protected $action = 'unsubscribe';

    protected function run(){        

        if(!$this->has('email') ||
          (!filter_var(sanitize_email($this->get('email')), FILTER_VALIDATE_EMAIL))){
            echo "Invalid Email";
            die;
        }

        SPDSGVOUnsubscriber::insert(array(
            'email'         => sanitize_email($this->get('email')),
            'integrations'  => array_keys($this->get('integrations', array())),
            'delete_on'     => strtotime("+1 week"),
        ));

    	wp_redirect(home_url());
        wp_logout();
		exit;
    }
}

SPDSGVOUnsubscribeAction::listen();