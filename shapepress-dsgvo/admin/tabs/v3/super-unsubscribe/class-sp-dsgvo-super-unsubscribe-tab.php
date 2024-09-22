<?php

class SPDSGVOSuperUnsubscribeTab extends SPDSGVOAdminTab{

	public $title = 'Delete request';
	public $slug = 'super-unsubscribe';

	public function __construct(){
	    $this->title = __('Delete request','shapepress-dsgvo');
	}

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
