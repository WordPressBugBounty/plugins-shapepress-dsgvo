<?php

class SPDSGVOWebinarsTab extends SPDSGVOAdminTab{

    public $title = 'Free Webinars';
    public $slug = 'webinars';
    public $isHidden = FALSE;

    public function __construct(){

        $this->title = __('Free Webinars','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
