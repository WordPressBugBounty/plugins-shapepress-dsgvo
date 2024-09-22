<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author     Shapepress eU
 */
class SPDSGVOSettings{

    public $defaults = array();

    private static $instance;
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __construct() {
        
        // dummy translation here
        __('WP DSGVO Tools (GDPR) help you to fulfill the GDPR (DGSVO)  compliance guidance (<a target="_blank" href="https://ico.org.uk/for-organisations/data-protection-reform/overview-of-the-gdpr/">GDPR</a>)', 'shapepress-dsgvo');               
        
        $this->defaults = array(
		/////////////////////////////////////
	    // common settings
	    ////////////////////////////////////
        'plugin_version'                    => '0',
	    'migration_history'                 => '',
	    'show_setup'                      	=> '0',
	    'license_key_error'                 => '1',
	    'license_activated'                 => '0',
	    'licence_activated_on'              => '2018-05-01',
	    'licence_valid_to'                  => '',
	    'licence_details_fetched'           => '0',
        'licence_details_fetched_new'       => '0',
        'show_invalid_license_notice'       => '0',
        'show_revoke_license_notice'        => '0',
        'licence_number_use_remaining'      => '0',
        'licence_status'                    => '',
	    'api_key' 		                    => '',
	    'admin_email'                      	=> '',
		'use_wpml_strings'                  => '0',
		'dsgvo_auto_update'					=> '0',
		'dsgvo_block_google_fonts'			=> '0',
	    'sp_dsgvo_comments_checkbox' 	    => '0',
	    'spdsgvo_comments_checkbox_confirm'	=> __('I confirm','shapepress-dsgvo'),
	    'spdsgvo_comments_checkbox_info' 	=> __('The confirmation to GDPR is mandatory.','shapepress-dsgvo'),
	    'spdsgvo_comments_checkbox_text' 	=> __('This form stores your name, email address and content so that we can evaluate the comments on our site. For more information, visit our Privacy Policy page.','shapepress-dsgvo'),

        'page_operator_type'                => 'one-man',
        'page_operator_company_name'        => '',
        'page_operator_company_law_person'  => '',
        'page_operator_operator_name'       => '',
        'page_operator_corp_public_law_name'            => '',
        'page_operator_corp_public_law_supervisor'      => '',
        'page_operator_corp_public_law_representative'  => '',
        'spdsgvo_company_info_name'         => '',
        'spdsgvo_company_info_street'       => '',
        'spdsgvo_company_info_loc_zip'      => '',
        'spdsgvo_company_info_countrycode'  => 'DE',
        'spdsgvo_company_fn_nr'             => '',
        'spdsgvo_company_law_loc'           => '',
        'spdsgvo_company_uid_nr'            => '',
        'spdsgvo_company_law_person'        => '',
        'spdsgvo_company_chairmen'          => '',
        'spdsgvo_company_resp_content'      => '',
        'spdsgvo_company_info_phone'        => '',
        'spdsgvo_company_info_fax'          => '',
        'spdsgvo_company_info_email'        => '',
        'spdsgvo_newsletter_service'        => '',
        'spdsgvo_newsletter_service_privacy_policy_url' => '',


		/////////////////////////////////////
		// SAR
		/////////////////////////////////////
		'sar_cron'	           	 => '0',
		'sar_page'		         => '0',
	    'sar_email_notification' => '0',
	    'sar_dsgvo_accepted_text'       => __('I agree to the storage of the data for processing within the meaning of the GDPR.','shapepress-dsgvo'),

		/////////////////////////////////////
		// Third-party Services
		/////////////////////////////////////
		'user_permissions_page' => '0',


		/////////////////////////////////////
		// Unsubscribe Page
		/////////////////////////////////////
		'super_unsubscribe_page' 	   => '0',
		'unsubscribe_auto_delete' 	   => '0',
	    'su_auto_del_time'             => '0',
	    'su_woo_data_action'           => 'ignore',
	    'su_bbpress_data_action'       => 'ignore',
	    'su_buddypress_data_action'    => 'ignore',
	    'su_email_notification'        => '0',
	    'su_dsgvo_accepted_text'       => __('I agree to the storage of the data for processing within the meaning of the GDPR.','shapepress-dsgvo'),


		/////////////////////////////////////
		// Cookie Notice
		////////////////////////////////////
        'cookie_version'                    => '0',
		'display_cookie_notice' 			=> '0',
		'force_cookie_info'                 => '0',
        'mandatory_integrations_editable'   => '0',
		'cookie_notice_custom_css' 			=> "",
	    'cookie_notice_text'                => __('To change your privacy setting, e.g. granting or withdrawing consent, click here:','shapepress-dsgvo'),
	    'cn_cookie_validity'                => '86400',
        'cn_cookie_validity_dismiss'        => '86400',
	    'cn_button_text_ok'                 => __('OK','shapepress-dsgvo'),
	    'cn_reload_on_confirm'              => '0',
        'cn_reload_on_confirm_popup'        => '0',
	    'cn_activate_cancel_btn'            => '1',
	    'cn_button_text_cancel'             => __('Deny','shapepress-dsgvo'),
	    'cn_decline_target_url'             => '',
	    'cn_activate_more_btn'              => '0',
	    'cn_button_text_more'               => __('More information','shapepress-dsgvo'),
	    'cn_read_more_page'                 => '',
	    'cn_position'                       => 'bottom',
	    'cn_animation'                      => 'none',
	    'cn_background_color'               => '#333333',
	    'cn_text_color'                     => '#ffffff',
	    'cn_background_color_button'        => '#009ecb',
	    'cn_border_color_button'            => '#F3F3F3',
	    'cn_border_size_button'             => '1px',
	    'cn_text_color_button'              => '#ffffff',
	    'cn_custom_css_container'           => '',
	    'cn_custom_css_text'                => '',
	    'cn_custom_css_buttons'             => '',
	    'cn_size_text'                      => '13px',
	    'cn_height_container'               => 'auto',
	    'cn_show_dsgvo_icon'                => '0',
	    'cn_use_overlay'                    => '0',
		'cookie_notice_display'             => 'none',
		'show_notice_on_close'              => '0',
		'cookie_style'                      => '00',
		'logo_image_id'                     => '0',
        'deactivate_load_popup_fonts'       => '0',

         /////////////////////////////////////
         // Embeddings
         //////////////////////////////////////
        'embed_placeholder_text_color' 		          => '#313334',
        'embed_placeholder_border_color_button'       => '#313334',
        'embed_placeholder_custom_style' 		      => 'background: linear-gradient(90deg, #e3ffe7 0%, #d9e7ff 100%);',
        'embed_placeholder_custom_css_classes'        => '',
		'embed_placeholder_border_size_button'        => '2px',
		'embed_enable_js_blocking'                    => '0',
        'embed_disable_negative_margin'               => '0',

		/////////////////////////////////////
		// Privacy Policy
		/////////////////////////////////////
		'privacy_policy' 		      => '',
		'privacy_policy_page' 	      => '0',
		'privacy_policy_version'      => '1',
		'privacy_policy_hash' 	      => '',
        'woo_show_privacy_checkbox'   => '0',
        'woo_show_privacy_checkbox_register' => '0',
		'woo_privacy_text'            => '',
		'wp_signup_checkbox_text'     => '',
        'wp_signup_checkbox_error'    => '',
		'wp_signup_show_privacy_checkbox' => '0',
		'privacy_policy_title_html_htag'        => 'h1',
        'privacy_policy_subtitle_html_htag'     => 'h2',
        'privacy_policy_subsubtitle_html_htag'  => 'h3',
        'privacy_policy_custom_header'  => __('Privacy Policy','shapepress-dsgvo'),
		'legal_web_texts_version'     => '0',
        'legal_web_texts_remote_version'     => '0',
        'legal_web_texts_remote_version_email_sent' => '0',
        'legal_web_texts_last_check'  => '0',
		'pp_texts_notification_mail'  => '0',

		/////////////////////////////////////
	    // imprint
	    /////////////////////////////////////
	    'imprint' 		 => '',
	    'imprint_page' 	 => '0',
	    'imprint_version' => '1',
	    'imprint_hash' 	 => '',

        'cb_spdsgvo_cl_vdv'                  => '0',
        'cb_spdsgvo_cl_filled_out'           => '0',
        'cb_spdsgvo_cl_maintainance'         => '0',
        'cb_spdsgvo_cl_security'             => '0',
        'cb_spdsgvo_cl_hosting'              => '0',
        'cb_spdsgvo_cl_plugins'              => '0',
        'cb_spdsgvo_cl_experts'              => '0',

        'google_gdpr_refresh_notice'         => '0',
        'show_notice_update_check_settings'  => '1',
        'show_notice_update_310'             => '1',
        'show_notice_webinars'               => '1',
        'show_notice_securityleak0921'       => '1',

	);


    }

	public static function init(){

	    $sInstance = (new self);
		$users = get_users(array('role' => 'administrator'));
		$admin = (isset($users[0]))? $users[0] : FALSE;
		if(!self::get('admin_email')){
			if($admin){
			    self::set('admin_email', $admin->user_email);
			}
		}

		foreach($sInstance->defaults as $setting => $value){
		    if(!self::get($setting)){
		        self::set($setting, $value);
			}
		}
	}

	public static function set($property, $value){
		update_option(SPDSGVOConstants::OPTIONS_PREFIX.$property, $value);
	}

	public static function get($property){
		$value = get_option(SPDSGVOConstants::OPTIONS_PREFIX .$property);

		if($value !== '0'){
			if(!$value || empty($value)){

			    $value = self::getDefault($property);
			}
		}

		return $value;
	}

	public static function getDefault($property){

	    $sInstance = new self;

	    if (array_key_exists($property, $sInstance->defaults))
	    {
	        return $sInstance->defaults[$property];
	    } else
	    {
	        return '';
	    }
	}

	public static function getAll()
    {
        $all_options = wp_load_alloptions();
        $my_options = array();
        foreach( $all_options as $name => $value ) {
            if(strpos($name,SPDSGVOConstants::OPTIONS_PREFIX) !== false) {
                if($value !== '0'){
                    if(!$value || empty($value)){

                        $value = self::getDefault($name);
                    } else
                    {
                        // check if its an array
                        //if (strpos($value, 'a:') === 0)
                        if (is_serialized($value))
                        {
                            try {
                                $newArray = unserialize($value);
                                //if ($newArray == false) echo 'SERIALIZE: '.$name .': '.$value;
                                if ($newArray  != false && is_array($newArray))
                                {
                                    $value = $newArray;
                                }
                            } catch (Exception $ex) {}
                        }

                    }
                }
                $my_options[str_replace(SPDSGVOConstants::OPTIONS_PREFIX,'', $name)] = $value;
            }
        }
        return array_merge(SPDSGVOSettings::getInstance()->defaults, $my_options);
    }

	public function __get($property){
	    return self::get($property);
	}

	public function __set($property, $value){
	    return self::set($property, $value);
	}
}
