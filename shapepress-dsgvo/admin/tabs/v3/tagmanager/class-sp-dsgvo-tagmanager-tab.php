<?php

class SPDSGVOTagmanagerIntegrationsTab extends SPDSGVOAdminTab{

    public $title = 'Tagmanager';
    public $slug = 'tagmanager-integrations';
    public $isHidden = FALSE;

    public function __construct(){

        $this->title = __('Tagmanager','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
