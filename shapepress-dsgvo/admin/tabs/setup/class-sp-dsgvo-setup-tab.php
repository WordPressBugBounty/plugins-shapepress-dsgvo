<?php

class SPDSGVOSetupTab extends SPDSGVOAdminTab{

    public $title = 'Setup';
    public $slug = 'setup';

    public function __construct(){
        $this->title = __('Setup','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
