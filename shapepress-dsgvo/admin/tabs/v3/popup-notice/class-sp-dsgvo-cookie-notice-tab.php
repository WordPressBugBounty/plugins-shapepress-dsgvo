<?php

class SPDSGVOCookieNoticeTab extends SPDSGVOAdminTab{

    public $title = 'Cookie Notice / Popup';
    public $slug = 'cookie-notice';
    public $isHidden = FALSE;

    public function __construct(){

        //$this->title = __('Cookie Notice / Popup','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
