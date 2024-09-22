<?php

Class SPDSGVOUnsubscriber extends SPDSGVOModel {

	public $postType = 'spdsgvo_unsubscriber';
	public $attributes = array(
		'first_name',
		'last_name',
		'email',
	    'dsgvo_accepted',
	    'process_now',

		'token',
		'status',
	);
	public $default = array(
		'status' => 'pending'
	);


	//======================================================================
	// doSuperUnsubscribe()
	//======================================================================
	public function doSuperUnsubscribe(){
	    $user = get_user_by('email', $this->email);
	    $ignored_roles = array('administrator');


	    if( array_intersect($ignored_roles, $user->roles ))
	    {
	        //error_log('doSuperUnsubscribe: user '.$this->email.' ignored because he has role of '.implode($user->roles));
	    } else
	    {
	        $this->status = 'in-progress';
	        $this->save();

	        $dataCollecter = new SPDSGVODataCollecter($this->email, $this->first_name, $this->last_name);
	        $dataCollecter->superUnsubscribe();

	        $this->status = 'done';
	        $this->save();
	    }
	}


	public static function doByID($ID){
	    $unsubscriber = self::find($ID);
        if(!is_null($unsubscriber)){
            $unsubscriber->doSuperUnsubscribe();
            return TRUE;
        }

        return FALSE;
	}

	//======================================================================
	// Finders
	//======================================================================
	public function _finderToken($args){
		 return array(
            'meta_query' => array(
                array(
                    'key'	=> 'token',
                    'value' => $args['token']
               	)
            )
        );
	}

	public function _postFinderToken($results, $args){
		return @$results[0];
	}

	public function _finderStatus($args){
		 return array(
            'meta_query' => array(
                array(
                    'key'	=> 'status',
                    'value' => $args['status']
               	)
            )
        );
	}

    public function _finderPending($args){
        return array(
            'meta_query' => array(
                array(
                    'key'	=> 'status',
                    'value' => 'pending'
                )
            )
        );
    }


	//======================================================================
	// Hooks
	//======================================================================
	public function inserting(){
	    $this->token = self::randomString();
	}

	public function inserted(){

	    if ($this->process_now === '1') return;

	    $locale = SPDSGVOLanguageTools::getInstance()->getCurrentLanguageCode();

        /* p912419 */
        $title = !empty( SPDSGVOSettings::get('su_email_title') ) ? SPDSGVOSettings::get('su_email_title') : __('Confirmation of delete request','shapepress-dsgvo');
        if(function_exists('icl_translate')) {
            $title = icl_translate('shapepress-dsgvo', 'su_email_title', $title);
        }

        $content = SPDSGVOSettings::get('su_email_content');
        if(function_exists('icl_translate')) {
            $content = icl_translate('shapepress-dsgvo', 'su_email_content', $content);
        }
        /* p912419 end */

		$email = SPDSGVOMail::init()
		    ->from(SPDSGVOSettings::get('admin_email'))
		    ->to($this->email)
		    ->subject($title. ': '. parse_url(home_url(), PHP_URL_HOST))
		    ->beforeTemplate(SPDSGVO::pluginDir('/templates/'.$locale.'/emails/header.php'))
		    ->afterTemplate( SPDSGVO::pluginDir('/templates/'.$locale.'/emails/footer.php'))
		    ->template(SPDSGVO::pluginDir('/templates/'.$locale.'/emails/super-unsubscribe.php'), array(
		    	'website' 		=> parse_url(home_url(), PHP_URL_HOST),
		    	'content'       => $content,
		    	'confirm_link'  => SPDSGVOSuperUnsubscribeConfirmAction::url(array(
		    		'token'		=> $this->token
		    	)),
                'home_url' 		=> home_url(),
				'admin_email' 	=> SPDSGVOSettings::get('admin_email'),
            ))
            ->send();
	}


	//======================================================================
	// Misc
	//======================================================================
	public function name(){
		return $this->first_name .' '. $this->last_name;
	}

	public static function randomString($len = 20){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for($i = 0; $i < $len; $i++){
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}



function registerUnsubscriberDSGVOModel(){
	SPDSGVOUnsubscriber::register(array(
		'show_in_nav_menus'   => FALSE,
		'show_in_menu' 		  => FALSE,
		'show_ui' 			  => FALSE,
		'publicly_queryable'  => FALSE,
		'exclude_from_search' => FALSE,
		'public' 			  => FALSE,
	));
}
add_action('init', 'registerUnsubscriberDSGVOModel');
