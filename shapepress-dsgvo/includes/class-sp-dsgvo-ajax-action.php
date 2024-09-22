<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author     Shapepress eU
 */
abstract class SPDSGVOAjaxAction{

	protected $action;
	public $user;

	abstract protected function run();

	public function __construct(){
		if($this->isLoggedIn()){
			$this->user = wp_get_current_user();
		}
	}

	public static function boot(){
	    $class = self::getClassName();
		$action = new $class;
		$action->run();

		if($action->has('href')){
    		wp_redirect($action->get('href'));
    	}else{
    	    if(isset($_SERVER['HTTP_REFERER'])) {
    	        header('Location: '. $_SERVER['HTTP_REFERER']);
    	    }
    	    else
    	    {
    	        //it was not sent, perform your default actions here
    	    }

    	}

		die;
	}

	public static function listen($public = TRUE){
	    $actionName = self::getActionName();
	    $className = self::getClassName();
		add_action("wp_ajax_$actionName", array($className, 'boot'));

		if($public){
			add_action("wp_ajax_nopriv_$actionName", array($className, 'boot'));
		}
	}


	// -----------------------------------------------------
	// UTILITY METHODS
	// -----------------------------------------------------
	public static function getClassName(){
		return esc_attr(get_called_class());
	}

	public static function formURL(){
		return esc_url(admin_url('/admin-ajax.php'));
	}

	public static function getActionName(){
	    $class = self::getClassName();
		$reflection = new ReflectionClass($class);
		$action = $reflection->newInstanceWithoutConstructor();
		if(!isset($action->action)){
			throw new Exception(__("Public property \$action not provied", 'shapepress-dsgvo'));
		}
		return esc_attr($action->action);
	}

	public function requireAdmin(){
		if(!current_user_can('administrator')){
            echo '0';
            die;
        }
	}

	public function checkCSRF(){

        $actionName = self::getActionName().'-nonce';
        $submittedNonce = sanitize_text_field( $_REQUEST['_wpnonce']);

        if ( wp_verify_nonce( $submittedNonce, $actionName ) ) {
            return TRUE;
        } else
        {
            echo 'CSRF ERROR: Nonce not valid';
            die;
            //return FALSE;
        }

	}

	public function error($message){
		echo esc_html($message);
		die();
	}


	// -----------------------------------------------------
	// JSONResponse
	// -----------------------------------------------------
	public function JSONResponse($response){
		wp_send_json($response);
	}


	// -----------------------------------------------------
	// Helpers
	// -----------------------------------------------------
	public static function ajaxURL(){
		?>
			<script type="text/javascript">
				var ajaxurl = '<?php echo esc_url(admin_url('/admin-ajax.php')); ?>';
			</script>
		<?php
	}

	public static function WP_HeadAjaxURL(){
		add_action('wp_head', array('WP_AJAX', 'ajaxURL'));
	}

	public static function url($params = array()){
		$params = http_build_query(array_merge(array(
			'action' => (new static())->action), $params),'', '&amp;');

        error_log($params);
		return admin_url('/admin-ajax.php') .'?'. $params;
	}

	public function isLoggedIn(){
		return is_user_logged_in();
	}

	public function has($key){
		if(isset($_REQUEST[$key])){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Get parameter from $_REQUEST array
	 * @param  string $key     key
	 * @param  string $default default string
     * @param  string $sanitizeMethod default sanitize_text_field
	 * @return mixed
	 */
	public function get($key, $default = NULL, $sanitizeMethod = 'sanitize_text_field', $stripslashes = TRUE){
		if($this->has($key)){

			$result = null;

			if(is_array($_REQUEST[$key])){
				return spDsgvo_recursive_sanitize_text_field($_REQUEST[$key]);
			}

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



	public function returnBack(){
		if(isset($_SERVER['HTTP_REFERER'])){
			header('Location: '. $_SERVER['HTTP_REFERER']);
			die();
		}

		return FALSE;
	}

	public function returnRedirect($url, $params = array()){
		$url .= '?'. http_build_query($params);
		header('Location: '. $url);
		die();
	}

}
