<?php

class SPDSGVOMailchimpIntegration extends SPDSGVOIntegration{

	public $slug = 'mailchimp';
	public $title = 'Mailchimp';

	public function boot(){
	    $this->isHidden = FALSE;
        $this->integrationCategory = SPDSGVOConstants::CATEGORY_SLUG_PLUGINS;
	    
		if(!class_exists('SPDSGVOMailChimp')){
			require_once dirname(__FILE__) .'/MailchimpAPI.php';
		}
	}

	public function view(){
		include dirname(__FILE__) .'/page.php';
	}
	
	public function viewSubmit(){

		$this->requireAdmin();

		if($this->has('mailchimp_api_token')){
			update_option('mailchimp_api_token', $this->get('mailchimp_api_token'));
		}

		$this->redirectBack();
	}


	// -----------------------------------------------------
	// Actions
	// -----------------------------------------------------
	public function onSuperUnsubscribe($email, $firstName = NULL, $lastName = NULL, $user = NULL){
		$mailChimp = new SPDSGVOMailChimp(get_option('mailchimp_api_token'));
        $lists = $mailChimp->get('lists');
        
        if(is_array($lists['lists'])){
            $hash = $mailChimp->subscriberHash($email);
            foreach($lists['lists'] as $list){
                $mailChimp->delete(
                	sprintf('lists/%s/members/%s', $list['id'], $hash)
                );
            }
        }
	}

	public function onSubjectAccessRequest($email, $firstName = NULL, $lastName = NULL, $user = NULL){
		
		// Your Code Here!

	}
}

SPDSGVOMailchimpIntegration::register();