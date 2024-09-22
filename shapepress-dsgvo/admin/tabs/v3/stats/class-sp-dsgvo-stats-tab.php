<?php

class SPDSGVOStatisticIntegrationsTab extends SPDSGVOAdminTab{

    public $title = 'Statistics';
    public $slug = 'statistic-integrations';
    public $isHidden = FALSE;

    public function __construct(){

        $this->title = __('Statistics','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
