<?php

/**
 * Register settings strings for Polylang
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author     Shapepress eU
 */
class SPDSGVOSettingsPolylang {

    public $defaults = array();

    public function __construct() {
        if(function_exists('icl_register_string')) :
            //ok
            icl_register_string('shapepress-dsgvo', 'spdsgvo_comments_checkbox_info', SPDSGVOSettings::get('spdsgvo_comments_checkbox_info'));
            //ok
            icl_register_string('shapepress-dsgvo', 'spdsgvo_comments_checkbox_confirm', SPDSGVOSettings::get('spdsgvo_comments_checkbox_confirm'));
            //ok
            icl_register_string('shapepress-dsgvo', 'spdsgvo_comments_checkbox_text', SPDSGVOSettings::get('spdsgvo_comments_checkbox_text'));
            //ok
            icl_register_string('shapepress-dsgvo', 'sar_dsgvo_accepted_text', SPDSGVOSettings::get('sar_dsgvo_accepted_text'));
            //ok

	        if(is_array(SPDSGVOSettings::get( 'services' ))) {
		        // Prevents illegal string offset warnings

		        if ( isset( SPDSGVOSettings::get( 'services' )['cookies'] )
		             && isset( SPDSGVOSettings::get( 'services' )['cookies']['reason'] ) ) {
		        	//ok
			        icl_register_string( 'shapepress-dsgvo', 'services_cookies_reason', SPDSGVOSettings::get( 'services' )['cookies']['reason'] );
		        }

		        if ( isset( SPDSGVOSettings::get( 'services' )['google-analytics'] )
		             && isset( SPDSGVOSettings::get( 'services' )['cookies']['reason'] ) ) {
			        //ok
			        icl_register_string( 'shapepress-dsgvo', 'services_google-analytics_reason', SPDSGVOSettings::get( 'services' )['google-analytics']['reason'] );
		        }

		        if ( isset( SPDSGVOSettings::get( 'services' )['google-fonts'] )
		             && isset( SPDSGVOSettings::get( 'services' )['cookies']['reason'] ) ) {
			        //ok
			        icl_register_string( 'shapepress-dsgvo', 'services_google-fonts_reason', SPDSGVOSettings::get( 'services' )['google-fonts']['reason'] );
		        }

		        if ( isset( SPDSGVOSettings::get( 'services' )['facebook-pixel'] )
		             && isset( SPDSGVOSettings::get( 'services' )['cookies']['reason'] ) ) {
			        //pl
			        icl_register_string( 'shapepress-dsgvo', 'services_facebook-pixel_reason', SPDSGVOSettings::get( 'services' )['facebook-pixel']['reason'] );
		        }
	        }
            //ok
            icl_register_string('shapepress-dsgvo', 'su_dsgvo_accepted_text', SPDSGVOSettings::get('su_dsgvo_accepted_text'));
            //ok
            icl_register_string('shapepress-dsgvo', 'cookie_notice_text', SPDSGVOSettings::get('cookie_notice_custom_text'));
            //ok
            icl_register_string('shapepress-dsgvo', 'cn_button_text_ok', SPDSGVOSettings::get('cn_button_text_ok'));
            //ok
            icl_register_string('shapepress-dsgvo', 'cn_button_text_cancel', SPDSGVOSettings::get('cn_button_text_cancel'));
            //ok
            icl_register_string('shapepress-dsgvo', 'cn_button_text_more', SPDSGVOSettings::get('cn_button_text_more'));

            icl_register_string('shapepress-dsgvo', 'terms_conditions', SPDSGVOSettings::get('terms_conditions'));
            //ok
            icl_register_string('shapepress-dsgvo', 'privacy_policy', SPDSGVOSettings::get('privacy_policy'));
            //ok
            icl_register_string('shapepress-dsgvo', 'imprint', SPDSGVOSettings::get('imprint'));
            //ok
            icl_register_string('shapepress-dsgvo', 'accept_button_text', SPDSGVOSettings::get('accept_button_text'));

            icl_register_string('shapepress-dsgvo', 'more_options_button_text', SPDSGVOSettings::get('more_options_button_text'));
            icl_register_string('shapepress-dsgvo', 'close_button_url', SPDSGVOSettings::get('close_button_url'));
            icl_register_string('shapepress-dsgvo', 'accordion_top', SPDSGVOSettings::get('accordion_top'));
        endif;
    }

}

new SPDSGVOSettingsPolylang();
