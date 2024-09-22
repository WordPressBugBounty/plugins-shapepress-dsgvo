<?php

/**
 * Abstract class that provides boilerplate methods for an extension.
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * Abstract class that provides boilerplate methods for an extension.
 *
 *
 * @since      1.0.0
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author     Shapepress eU
 */
abstract class SPDSGVOAdminTab{

	public $isHidden = false;
	public $isHighlighted = false;

	public function uri(){
        return sprintf('%sadmin.php?page=sp-dsgvo&tab=%s', get_admin_url(), $this->slug); 
    }

    public function isHidden(){
    	if(!isset($this->isHidden)){
    		return false;
    	}
    	
    	return $this->isHidden;
    }
    
    public function isHighlighted(){
        if(!isset($this->isHighlighted)){
            return false;
        }
        
        return $this->isHighlighted;
    }

    public static function getClassName(){
        return get_called_class();
    }

    public static function getTabTitle(){
        $class = self::getClassName();
        $reflection = new ReflectionClass($class);
        $tab = $reflection->newInstanceWithoutConstructor();
        if(!isset($tab->title)){
            throw new Exception(__("Public property \$action not provided", 'shapepress-dsgvo'));
        }
        return $tab->title;
    }
}