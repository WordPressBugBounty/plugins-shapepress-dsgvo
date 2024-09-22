<?php

function SPDSGVOCookiePopupLinkShortcode($atts){

    $params = shortcode_atts( array (
        'class' => '',
        'text' => __('Cookie Popup','shapepress-dsgvo'),
    ), $atts );


    return '<a href="#" class="sp-dsgvo-show-privacy-popup '.esc_attr($params['class']).'">' . esc_html($params['text']) . "</a>";
}

add_shortcode('cookie_popup_link', 'SPDSGVOCookiePopupLinkShortcode');
