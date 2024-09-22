<?php

class SPDSGVOSubjectAccessRequestTab extends SPDSGVOAdminTab{

	public $title ='Subject Access Request';
	public $slug = 'subject-access-request';

	public function __construct(){

	    $this->title = __('Subject Access Request','shapepress-dsgvo');
	}

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
