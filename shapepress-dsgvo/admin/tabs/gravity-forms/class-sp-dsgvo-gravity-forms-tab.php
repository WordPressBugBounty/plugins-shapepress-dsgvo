<?php

class SPDSGVOGravityFormsTab extends SPDSGVOAdminTab{

	public $title = 'Gravity Forms';
	public $slug = 'gravity-forms';

	public function __construct(){

	    $this->title = __('Gravity Forms','shapepress-dsgvo');
	}

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }


	/**
	 * Returns an array of Gravity Forms data.
	 */
	public static function get_gf_forms() {

		$output = array();
		$forms = GFAPI::get_forms();

		foreach ( $forms as $form ) {
			$output[ $form['id'] ] = $form;
		}

		return $output;

	}

}
