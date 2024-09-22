<?php

class SPDSGVOOperatorTab extends SPDSGVOAdminTab{

    public $title = 'Operator';
    public $slug = 'operator';
    public $isHidden = FALSE;

    public function __construct(){

        $this->title = __('Operator','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
