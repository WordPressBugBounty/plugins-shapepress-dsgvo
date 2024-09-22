<?php

class SPDSGVOIntegration extends SPDSGVOAdminTab{

    public $integrationCategory = '';
    public $slug = '';
    public $title = '';
    public $isPremium = false;
    public $apiInstance = null;

    public function __construct(){
	    $this->isHidden = FALSE;
	    
		if(method_exists($this, 'boot')){
			$this->boot();
		}
	}

	public static function register(){
		$class = get_called_class();
		$self = new $class();

		if(method_exists($self, 'viewSubmit') && current_user_can('administrator')){
			$action = $class::action();
			add_action("wp_ajax_$action", array($self, 'viewSubmit'));
			add_action("wp_ajax_nopriv_$action", array($self, 'viewSubmit'));
		}

		add_filter('sp_dsgvo_integrations_'.$self->integrationCategory, array($class, 'registerCallback'));

		if(self::isEnabled($self->slug)){
			add_filter('sp_dsgvo_integrations_safe_'.$self->integrationCategory, array($class, 'registerCallback'));
		}
	}

	public static function registerCallback($integrations){
		$class = get_called_class();
		$self = new $class;
		$integrations[$self->slug] = $self;
		return $integrations;
	}

	public static function getAllIntegrations($type, $safe = TRUE){
		if($safe){
			return apply_filters('sp_dsgvo_integrations_safe_'.$type, array());
		}else{
			return apply_filters('sp_dsgvo_integrations_'.$type, array());
		}
	}

	public static function action(){
		$class = get_called_class();
		return 'SPDSGVO-integration-'. self::slug(); 
	}

	public static function slug(){
		$class = get_called_class();
		$self = new $class;
		return $self->slug;
	}

	// Note: I did this because I don't
	// like the method name page() now, 
	// I prefur name view() instead. So
	// that's why this dirty function exists
	public function page(){
		if(method_exists($this, 'view')){
			$this->view();
		}
	}


	// -----------------------------------------------------
	// Helpers
	// -----------------------------------------------------
	public static function formURL(){
		return admin_url('/admin-ajax.php');
	}

	public static function isEnabled($slug){
		return SPDSGVOSettings::get('is_enabled_'.$slug) === SPDSGVOSettings::get('integration_enable_key');
	}

	public function has($key){
		return isset($_REQUEST[$key]);
	}

	public function get($key, $default = NULL, $sanitizeMethod = 'sanitize_text_field', $stripslashes = TRUE){
		if($this->has($key)){

			$result = null;

			if ($sanitizeMethod != 'wp_kses_scripts') {
				if(isset($sanitizeMethod) && function_exists($sanitizeMethod)){
					$result = call_user_func($sanitizeMethod, $_REQUEST[$key]);
				}
			} else if ($sanitizeMethod == 'wp_kses_scripts'){
				$result = wp_kses($_REQUEST[$key], $this->getAllowedHtmlForScriptsForKses());
			} else {
				return null;
			}

			if($stripslashes && isset($result)){
				$result = stripslashes($result);
			}

			return $result;
		}
		return $default;
	}

	function getAllowedHtmlForScriptsForKses() {
		return  array_merge(
			wp_kses_allowed_html( 'post' ),
			array(
				'script' => array(
					'type' => array(),
					'src' => array(),
					'charset' => array(),
					'async' => array()
				),
				'noscript' => array(),
				'style' => array(
					'type' => array()
				),
				'iframe' => array(
					'src' => array(),
					'height' => array(),
					'width' => array(),
					'frameborder' => array(),
					'allowfullscreen' => array()
				)
			)
		);

	}

	public function redirectBack(){
		ob_clean();
		header('Location: '. $_SERVER['HTTP_REFERER']);
		die();
	}

	public function requireAdmin(){
		if(!current_user_can('administrator')){
			echo '0';
			die;
		}
	}

	public function checkCSRF(){

		$actionName = self::action().'-nonce';
		$submittedNonce = sanitize_text_field($_REQUEST['_wpnonce']);

		if ( wp_verify_nonce( $submittedNonce, $actionName ) ) {
			return TRUE;
		} else
		{
			echo 'CSRF ERROR: Nonce not valid';
			die;
			//return FALSE;
		}

	}
}