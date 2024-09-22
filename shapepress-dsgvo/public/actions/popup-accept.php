<?php
/* i592995 */
Class SPDSGVOUserPopupAccept extends SPDSGVOAjaxAction{

    protected $action = 'popup-accept';

    protected function run(){
        $user = wp_get_current_user();
        if($user->ID != 0) {
            $meta = get_user_meta($user->ID, 'sp_dsgvo_popup', TRUE);
            update_user_meta( $user->ID, 'sp_dsgvo_popup', '1' );
        }
        else 
        {
            // fallback: create cookie because in js sometimes it does not get created
            //setcookie("sp_dsgvo_popup", "true", 
            //      SPDSGVOSettings::get('cn_cookie_validity'),
            //      (defined('COOKIEPATH') ? COOKIEPATH : ''));
        }
        die;
    }
}

SPDSGVOUserPopupAccept::listen();
/* i592995 */
