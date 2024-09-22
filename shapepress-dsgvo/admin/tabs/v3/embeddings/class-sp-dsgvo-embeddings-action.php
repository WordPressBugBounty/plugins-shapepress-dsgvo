<?php

Class SPDSGVOEmbeddingsIntegrationAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-embeddings-integrations';




    protected function run(){
        $this->checkCSRF();
        $this->requireAdmin();


        $saveAction = $this->get('saveAction', 'save');

        if ($saveAction == "save") {
            SPDSGVOSettings::set('embed_placeholder_text_color', $this->get('embed_placeholder_text_color', '#313334','sanitize_hex_color'));
            SPDSGVOSettings::set('embed_placeholder_border_color_button', $this->get('embed_placeholder_border_color_button', '#313334','sanitize_hex_color'));
            SPDSGVOSettings::set('embed_placeholder_border_size_button', $this->get('embed_placeholder_border_size_button', '2px'));
            SPDSGVOSettings::set('embed_placeholder_custom_style', $this->get('embed_placeholder_custom_style', ''));
            SPDSGVOSettings::set('embed_placeholder_custom_css_classes', $this->get('embed_placeholder_custom_css_classes', ''));
            SPDSGVOSettings::set('embed_disable_negative_margin', $this->get('embed_disable_negative_margin', '0'));
        } else if ($saveAction == "restore") {
            SPDSGVOSettings::set('embed_placeholder_text_color', '#313334','sanitize_hex_color');
            SPDSGVOSettings::set('embed_placeholder_border_color_button', '#313334','sanitize_hex_color');
            SPDSGVOSettings::set('embed_placeholder_border_size_button', '2px');
            SPDSGVOSettings::set('embed_placeholder_custom_style', 'background: linear-gradient(90deg, #e3ffe7 0%, #d9e7ff 100%;');
            SPDSGVOSettings::set('embed_placeholder_custom_css_classes', '','');
            SPDSGVOSettings::set('embed_disable_negative_margin', '0');
        } else if ($saveAction == "common") {

            SPDSGVOSettings::set('embed_enable_js_blocking', $this->get('embed_enable_js_blocking', '0'));
        }

        $this->returnBack();
    }
}

SPDSGVOEmbeddingsIntegrationAction::listen();
