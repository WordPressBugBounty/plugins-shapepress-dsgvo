<?php

class SPDSGVOInfoTab extends SPDSGVOAdminTab{

    public $title = 'V3 must read';
    public $slug = 'info';
    public $isHidden = FALSE;

    public function __construct(){

        $this->title = __('V3 must read','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
