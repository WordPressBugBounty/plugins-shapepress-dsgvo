<?php

class SPDSGVOCommonSettingsTab extends SPDSGVOAdminTab{

    public $title = 'Common Settings';
    public $slug = 'common-settings';
    public $isHidden = FALSE;

    public function __construct(){

        //$this->title = __('Tracking Scripts (GA & FB Pixel)','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
