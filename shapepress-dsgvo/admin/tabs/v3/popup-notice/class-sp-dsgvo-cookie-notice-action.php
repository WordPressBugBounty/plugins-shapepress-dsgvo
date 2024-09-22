<?php

Class SPDSGVOCookieNoticeAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-cookie-notice';

    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();


        SPDSGVOSettings::set('cookie_notice_display', $this->get('cookie_notice_display', 'none'));
        SPDSGVOSettings::set('show_notice_on_close', $this->get('show_notice_on_close', '0'));
        SPDSGVOSettings::set('force_cookie_info', $this->get('force_cookie_info', '0'));
	    SPDSGVOSettings::set('run_necessary_automatically', $this->get('run_necessary_automatically', '0'));
        SPDSGVOSettings::set('mandatory_integrations_editable', $this->get('mandatory_integrations_editable', '0'));
        SPDSGVOSettings::set('cookie_notice_text', $this->get('cookie_notice_text', ''));
        SPDSGVOSettings::set('cn_cookie_validity', is_numeric($this->get('cn_cookie_validity', '86400')) ? $this->get('cn_cookie_validity', '86400') : '86400');
        SPDSGVOSettings::set('cn_cookie_validity_dismiss', is_numeric($this->get('cn_cookie_validity_dismiss', '86400')) ? $this->get('cn_cookie_validity_dismiss', '86400') : '86400');
        SPDSGVOSettings::set('cookie_version', $this->get('cookie_version', ''));
        SPDSGVOSettings::set('cn_position', $this->get('cn_position', 'bottom'));
        SPDSGVOSettings::set('cn_animation', $this->get('cn_animation', 'none'));
        SPDSGVOSettings::set('cn_size_text', $this->get('cn_size_text', 'auto'));
        SPDSGVOSettings::set('popup_dark_mode', $this->get('popup_dark_mode', '0'));
        SPDSGVOSettings::set('deactivate_load_popup_fonts', $this->get('deactivate_load_popup_fonts', '0'));

        SPDSGVOSettings::set('cn_show_dsgvo_icon', $this->get('cn_show_dsgvo_icon', '0'));


        SPDSGVOSettings::set('cn_background_color', $this->get('cn_background_color', '#333333','sanitize_hex_color'));
        SPDSGVOSettings::set('cn_text_color', $this->get('cn_text_color', '#ffffff','sanitize_hex_color'));
        SPDSGVOSettings::set('cn_background_color_button', $this->get('cn_background_color_button', '#F3F3F3','sanitize_hex_color'));
        SPDSGVOSettings::set('cn_border_color_button', $this->get('cn_border_color_button', '#F3F3F3','sanitize_hex_color'));
        SPDSGVOSettings::set('cn_border_size_button', $this->get('cn_border_size_button', '1px'));
        SPDSGVOSettings::set('cn_text_color_button', $this->get('cn_text_color_button', '#333333','sanitize_hex_color'));
        SPDSGVOSettings::set('cn_custom_css_container', $this->get('cn_custom_css_container', ''));
        SPDSGVOSettings::set('cn_custom_css_text', $this->get('cn_custom_css_text', ''));
        SPDSGVOSettings::set('cn_custom_css_buttons', $this->get('cn_custom_css_buttons', ''));


        SPDSGVOSettings::set('cn_height_container', $this->get('cn_height_container', 'auto'));

        SPDSGVOSettings::set('cn_use_overlay', $this->get('cn_use_overlay', '0'));


        SPDSGVOSettings::set('logo_image_id', $this->get('logo_image_id', ''));
        SPDSGVOSettings::set('cookie_style', $this->get('cookie_style', '00'));


        SPDSGVOCacheManager::clearCaches();
        $this->returnBack();
    }
}

SPDSGVOCookieNoticeAction::listen();
