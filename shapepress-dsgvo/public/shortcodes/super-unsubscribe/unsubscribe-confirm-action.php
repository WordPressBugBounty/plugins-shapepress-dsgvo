<?php

Class SPDSGVOSuperUnsubscribeConfirmAction extends SPDSGVOAjaxAction{

    protected $action = 'super-unsubscribe-confirm';

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
        
        if(!$this->has('token')){
            $this->error(__('No token provided.','shapepress-dsgvo'));
        }

        $unsubscriber = SPDSGVOUnsubscriber::finder('token', array(
            'token' => $this->get('token')
        ));

        if(is_null($unsubscriber)){
            $this->error(__('Bad token provided','shapepress-dsgvo'));
        }

        if ($unsubscriber->status === 'unconfirmed') {
            $this->notifyAdmin($unsubscriber->email);

            if(SPDSGVOSettings::get('unsubscribe_auto_delete') == '1'){
                $unsubscriber->doSuperUnsubscribe();
            }else{
                $unsubscriber->status = 'pending';
                $unsubscriber->save();
            }
        }

        $superUnsubscribePage = SPDSGVOSettings::get('super_unsubscribe_page');
        if($superUnsubscribePage !== '0'){
            $url = get_permalink($superUnsubscribePage);
            $this->returnRedirect($url, array(
                'result' => $unsubscriber->status === 'done' ? 'confirmed' : 'request_confirmed',
            ));
        }
        
    }
}

SPDSGVOSuperUnsubscribeConfirmAction::listen();
