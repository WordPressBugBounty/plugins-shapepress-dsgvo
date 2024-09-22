<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/admin
 * @author     Shapepress eU
 */
class SPDSGVOAdmin{


	public $tabs = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sp_dsgvo       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct(){
		$this->tabs = array_merge(array(
			//'overview' 					=> new SPDSGVOOverviewTab,
		    'common-settings' 			=> new SPDSGVOCommonSettingsTab,
		    'cookie-notice' 			=> new SPDSGVOCookieNoticeTab,
		    'operator'                  => new SPDSGVOOperatorTab,
		    'page-basics'               => new SPDSGVOPageBasicsTab,
            'tagmanager-integrations'   => new SPDSGVOTagmanagerIntegrationsTab,
            'statistic-integrations'    => new SPDSGVOStatisticIntegrationsTab,
            'targeting-integrations'    => new SPDSGVOTargetingIntegrationsTab,
            'embeddings-integrations'   => new SPDSGVOEmbeddingsIntegrationsTab,
			'subject-access-request' 	=> new SPDSGVOSubjectAccessRequestTab,
			'super-unsubscribe' 		=> new SPDSGVOSuperUnsubscribeTab,
			'integrations'				=> new SPDSGVOIntegrationsTab,
            'webinars' 			        => new SPDSGVOWebinarsTab
            //'info' 			            => new SPDSGVOInfoTab
        ));

		if (isValidPremiumEdition())
		{
		    // Gravity Forms Tab
		    if(class_exists('GFAPI')){
		        $this->tabs = array_merge( $this->tabs, array('gravity-forms' => new SPDSGVOGravityFormsTab) );
		    }
		}

        SPDSGVOLanguageTools::getInstance()->checkMinVersionOfTexts();
	}

	public function menuItem()
    {
        global $submenu;
        
        $user = wp_get_current_user();
        $allowed_roles = array('administrator');
        
        if( array_intersect($allowed_roles, $user->roles ) || is_super_admin() ) {
           
    
    		$svg = 'data:image/svg+xml;base64,'. base64_encode(file_get_contents(SPDSGVO::pluginDir('public/images/legalwebio-logo-icon-white.svg')));
            add_menu_page('WP DSGVO Tools', 'WP DSGVO Tools',  'manage_options', 'sp-dsgvo', array($this, 'adminPage'), $svg, null);

            //add_submenu_page('sp-dsgvo', __('V3 definitely read','shapepress-dsgvo'), __('V3 definitely read','shapepress-dsgvo'),  'manage_options', 'admin.php?page=sp-dsgvo&tab=info');

            add_submenu_page('sp-dsgvo', __('Common','shapepress-dsgvo'), __('Common','shapepress-dsgvo'),  'manage_options', 'sp-dsgvo', array($this, 'adminPage'));


    		$first = true;
            foreach($this->tabs as $t):
                if ($first === true) {
                    $first = false;
                    continue;
                }
                if(!$t->isHidden()):
                    add_submenu_page('sp-dsgvo', $t->title,  $t->title, 'manage_options', 'admin.php?page=sp-dsgvo&tab='.$t->slug);

                endif;
            endforeach;

    		$index = 6 + count($this->tabs);
    		$menu_slug = 'sp-dsgvo';
    
    		//$submenu[$menu_slug][$index++] = array(__('Experts Info','shapepress-dsgvo'), 'manage_options', 'https://wp-dsgvo.eu/experten');
    		//$submenu[$menu_slug][$index++] = array(__('Legal advice','shapepress-dsgvo'), 'manage_options', 'https://wp-dsgvo.eu/tipps-hilfe');
    		$submenu[$menu_slug][$index++] = array(__('FAQ','shapepress-dsgvo'), 'manage_options', 'https://legalweb.freshdesk.com/support/solutions');
            //$submenu[$menu_slug][$index++] = array(__('GDPR Shortinfo','shapepress-dsgvo'), 'manage_options', 'https://legalweb.io/wp-content/uploads/2019/11/mr-legalweb_web.pdf');
    		//$submenu[$menu_slug][$index++] = array(__('About WP DSGVO Tools','shapepress-dsgvo'), 'manage_options', 'https://wp-dsgvo.eu/about');
            $submenu[$menu_slug][$index++] = array(__('About legal web','shapepress-dsgvo'), 'manage_options', 'https://legalweb.io');
        }
	}


	public function adminPage(){
		$tabs = $this->tabs;

		if(isset($_GET['tab'])){
			$tab = sanitize_text_field($_GET['tab']);
		}else{
		    $tab = 'common-settings';
// 			if(in_array('setup', array_keys($this->tabs))){
// 				$tab = 'setup';
// 			}else{
// 				$tab = 'overview';
// 			}
		}

		include SPDSGVO::pluginDir('admin/base.php');
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(){
        wp_enqueue_style(sp_dsgvo_NAME.'-bootstrap', plugin_dir_url(__FILE__). 'css/bootstrap.min.css', array(), sp_dsgvo_VERSION, 'all' );
        wp_enqueue_style(sp_dsgvo_NAME, plugin_dir_url(__FILE__). 'css/sp-dsgvo-admin.css', array(), sp_dsgvo_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(){
		/* i592995 */
		wp_enqueue_media();
		/* i592995 */
		wp_enqueue_script(sp_dsgvo_NAME, plugin_dir_url(__FILE__). 'js/sp-dsgvo-admin.js', array('jquery'), sp_dsgvo_VERSION, false );

		/* i592995 */
		wp_localize_script(sp_dsgvo_NAME, 'args', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
			'dismiss_confirm' => __('Are you sure you want to dismiss this request?', 'shapepress-dsgvo')
        ));

      //  wp_enqueue_script(sp_dsgvo_NAME.'-bootstrap', plugin_dir_url(__FILE__). 'js/bootstrap-min.js', array('jquery'), sp_dsgvo_VERSION, false );


    }



	public function enqueueColorPicker($hook_suffix){
	    wp_enqueue_style( 'wp-color-picker' );
   		wp_enqueue_script( 'wp-color-picker');
	}


	public function addCustomPostStates($states, $post){

		$pages = array(
		    SPDSGVOSettings::get('user_permissions_page') 	 => __('Privacy settings user page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('super_unsubscribe_page') 	 => __('Delete request page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('terms_conditions_page') 	 => __('Terms page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('explicit_permission_page') => __('Explicit permissions page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('opt_out_page') 			 => __('Opt Out page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('privacy_policy_page')		 => __('Privacy policy page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('sar_page')		 		 => __('Subject access request page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('imprint_page')		 	 => __('Imprint page','shapepress-dsgvo')
		);

	    if(in_array($post->ID, array_keys($pages))){
			$states[] =  $pages[$post->ID];
	    }

    	return $states;
	}


	/**
	 * Filter: Adds Extra Column to users table
	 *
	 * @since    1.0.0
	 * @author Shapepress eU
	 */
	public function addExplicitPermissionColumn($column){
	    $column['terms'] = 'Terms';
	    return $column;
	}


	/*
	* Gravity Forms Action
	*/
	public function gf_after_submisison_cleanse( $entry, $form ){

		// DELETE ALL ENTRIES
		if( SPDSGVOSettings::get('gf_save_no_data') ){
			GFAPI::delete_entry( $entry['id'] );
			return;
		}

		// DELETE IP and USER AGENT
		if( SPDSGVOSettings::get('gf_no_ip_meta') ){
			GFAPI::update_entry_property( $entry['id'], 'ip', '' );
			GFAPI::update_entry_property( $entry['id'], 'user_agent', '' );
		}

		// update fields to 'removed' that have been selected as 'do not save'
		$fields_to_delete = SPDSGVOSettings::get('gf_save_no_');
		if( !is_array($fields_to_delete) ){
			return;
		}
		if( isset($fields_to_delete[$form['id']]) ){
			foreach($fields_to_delete[$form['id']] as $field_id=>$check){
				if(!$check){
					continue;
				}

				if( isset($entry[$field_id]) ){
					// single level data
					GFAPI::update_entry_field( $entry['id'], $field_id, 'Removed' );
				} else {
					// multi level data (eg checkbox)
					$fields = preg_grep("/^".$field_id.".([0-9]*)$/", array_keys($entry)); // find keys like 2.1, 2.2 etc

					foreach( $fields as $field_id_key){
						if( $entry[$field_id_key] != '' ){
							GFAPI::update_entry_field( $entry['id'], $field_id_key, 'Removed' );
						}
					}
				}

			}
		}

	}
	
	function dsvgvo_admin_notices() {
	    
	    if (SPDSGVOSettings::get('google_gdpr_refresh_notice') != '1') {
    	    $class = 'notice notice-warning is-dismissible google-gdpr-refresh-notice';
    	    $message = __( 'Attention. Google has changed his GDPR texts. Please refresh your Privacy Policy by pressing "Reload ... template" button under privacy policy settings.', 'shapepress-dsgvo' );
    	    
    	    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
		}
		
		if (isPremiumEdition() && SPDSGVOSettings::get('show_invalid_license_notice') != '0')
	    {
	        $class = 'notice notice-warning is-dismissible license-invalid-notice';
	        $message = __( 'Attention. Your license is not valid any more. Please check WP DSGVO Tools settings to extend your license or visit <a href="URL_HERE" target="_blank">https://legalweb.io/shop</a> to extend it.', 'shapepress-dsgvo' );
	        $message = str_replace('URL_HERE', getExtensionProductUrl(), $message);
	        
	        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ),  $message );
	    }
	    
	    if (isPremiumEdition() && SPDSGVOSettings::get('show_revoke_license_notice') === '1')
        {
            $class = 'notice notice-info is-dismissible license-revoke-notice';
            $message = __( 'Information: Your licence will be renewed in a few days automatically if you have not canceled your legalweb.io subscription for this license. If you have canceled it, you have to extend it manually. To extend your license manually visit <a href="URL_HERE" target="_blank">https://legalweb.io/shop</a>.', 'shapepress-dsgvo' );
            $message = str_replace('URL_HERE', getExtensionProductUrl(), $message);

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
        }

        if (SPDSGVOSettings::get('show_notice_privacy_policy_texts_outdated') === '1')
        {
            $class = 'notice notice-warning is-dismissible privacy-policy-texts-outdated-notice';
            $message = __( 'Attention. There are newer texts for the privacy policy. Please refresh them ensure compliance. <a href="#" class="privacy-policy-texts-refresh-link">Refresh Texts</a>', 'shapepress-dsgvo' );
            //$url = admin_url( '/admin.php?page=sp-dsgvo&action='.SPDSGVOUpdatePrivacyPolicyTextsAction::getActionName(), 'https' );
            //$message = str_replace('URL_HERE', $url, $message);

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
        }
/*
        if (SPDSGVOSettings::get('show_notice_update_check_settings') === '1')
        {
            $class = 'notice notice-warning is-dismissible update-check-settings-notice';
            $message = __( 'Attention. Due to our mayor update you need to check all settings of WP DSGVO Tools (GDPR), especially page opator setting to ensure that the plugin outputs legal compliant texts. Also select the correct country to ensure to get the corect text base. We are sorry for this additional work, but otherwise we cant produce legal compliant texts for privacy policy, popup and the imprint.', 'shapepress-dsgvo' );

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
        }
*/
/*
        if (SPDSGVOSettings::get('show_notice_update_310') === '1')
        {
            $class = 'notice notice-info is-dismissible sp-dsgvo-admin-notice update-notice-version-310';
            $message = sprintf(__( 'Since version 3.1, the premium version is able to embed <strong>external content like YouTube, Facebook, Google Maps or other</strong> external content GDPR compliant. With opt-in decision your visitor can choose what to agree to. No 3rd party cookies of your external content gets created before. Just enable them in the plugin menu item <strong><a href="%s" >Embeddings</a></strong>.', 'shapepress-dsgvo' ), get_admin_url()."admin.php?page=sp-dsgvo&tab=embeddings-integrations");

            printf( '<div class="%1$s"><h4>WP DSGVO Tools (GDPR)</h4><p>%2$s</p></div>', esc_attr( $class ), $message );
        }
*/
        if (SPDSGVOSettings::get('show_notice_webinars') === '1')
        {
            $class = 'notice notice-info is-dismissible sp-dsgvo-admin-notice feature-notice-webinars';

            $message = sprintf(__( '<strong>Free webinars on websites, web shops &amp; law</strong><br />We have a new free support option for free, premium and cloud users - every Wednesday from 4:00 p.m. you can find out in our free webinar series, which is important for websites and web shops: <a href="%s" title="Webinar Dates">to the appointment overview</a>', 'shapepress-dsgvo' ), get_admin_url()."admin.php?page=sp-dsgvo&tab=webinars");

            printf( '<div class="%1$s"><h4>WP DSGVO Tools (GDPR)</h4><p>%2$s</p></div>', esc_attr( $class ), $message );
        }
/*
		if (SPDSGVOSettings::get('show_notice_securityleak0921') === '1')
		{
			$class = 'notice notice-warning is-dismissible sp-dsgvo-admin-notice update-notice-securityleak0921';
			$message = __( 'Due to a security issue in our prior version which has been fixed in this version, <strong>all integrations have been disabled</strong> because they might have been changed and forward your visitors to another URL. Please <strong>check the scripts if these are your correct tracking scripts before enabling them again.</strong>');

			printf( '<div class="%1$s"><h4>WP DSGVO Tools (GDPR)</h4><p>%2$s</p></div>', esc_attr( $class ), $message );
		}
*/
	}
/*
	function showUpgradeMessage($currentPluginMetadata, $newPluginMetadata)
    {
        // currently we use the inbuilt methods for displaying the notice
        //(new SPDSGVOUpgradeNoticeTools())->in_plugin_update_message($data, $response);
        if (isset($newPluginMetadata->upgrade_notice) && strlen(trim($newPluginMetadata->upgrade_notice)) > 0){
            $output = '<div class="sp-dsgvo_plugin_upgrade_notice"><div class="header">'. __('Important Upgrade Notice:','shapepress-dsgvo') .'</div> ';
            $output .= $newPluginMetadata->upgrade_notice . '</div>';
            $output =   preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $output);
            echo esc_html($output);
        }
    }
*/
}
