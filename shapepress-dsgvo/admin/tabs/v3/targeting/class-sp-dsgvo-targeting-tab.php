<?php

class SPDSGVOTargetingIntegrationsTab extends SPDSGVOAdminTab{

    public $title = 'Targeting';
    public $slug = 'targeting-integrations';
    public $isHidden = FALSE;

    public function __construct(){

        $this->title = __('Targeting','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
