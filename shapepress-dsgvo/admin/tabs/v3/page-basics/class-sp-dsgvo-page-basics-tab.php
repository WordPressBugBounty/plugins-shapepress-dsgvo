<?php

class SPDSGVOPageBasicsTab extends SPDSGVOAdminTab{

    public $title = 'Page Basics';
    public $slug = 'page-basics';
    public $isHidden = FALSE;

    public function __construct(){

        $this->title = __('Page Basics','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
