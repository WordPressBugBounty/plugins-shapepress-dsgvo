<?php

/**
 * Post Model for Logs
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * Post Model for Logs
 *
 * @since 1.0.0
 * @package WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author Shapepress eU
 */
class SPDSGVOLog
{

    public static $tableName = 'sp_dsgvo_logs';

    public $ID;

    public $date;

    public $content;

    public function __construct($content = '')
    {
        $this->content = $content;
        $this->date = date("Y-m-d H:i:s");
        
        try {
            if($this->tableExists() === FALSE){
                $this->migrate();
            }
        } catch (Exception  $e){}
    }

    public function boot()
    {
        global $wpdb;
        $tableName = $wpdb->prefix . self::$tableName;
        $result = $wpdb->get_results("SELECT * from $tableName WHERE `ID` = $this->ID");
        
        if (isset($result[0]->log_content)) {
            $this->date = $result[0]->log_date;
            $this->content = $result[0]->log_content;
        }
    }

    public static function migrate()
    {
        global $wpdb;
        $tableName = $wpdb->prefix . self::$tableName;
        
        $wpdb->get_var("
			CREATE TABLE `$tableName` (
				`ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				`log_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				`log_content` longtext NOT NULL,
				PRIMARY KEY (`ID`)
			)
		");
        
        $error = $wpdb->last_error;
        return ($error) ? $error : TRUE;
    }

    public static function tableExists()
    {
        global $wpdb;
        
        $tableName = $wpdb->prefix . self::$tableName;
        
        return $wpdb->get_var("SHOW TABLES LIKE '$tableName'") == $tableName;
    }

    public static function insert($content)
    {
        $log = new self($content);
        $log->save();
        return $log;
    }

    public static function find($ID)
    {
        $log = new self();
        $log->ID = $ID;
        $log->boot();
        return $log;
    }

    public static function all()
    {
        try {
            global $wpdb;
            $tableName = $wpdb->prefix . self::$tableName;
            
            $result = $wpdb->get_results("SELECT * FROM $tableName ORDER BY ID DESC");
            
            $logs = array();
            foreach ($result as $key => $row) {
                array_push($logs, self::find($row->ID));
            }
            
            return $logs;
        } catch (Exception  $e){
            return array();
        }
    }

    public static function mostRecent($limit = 15)
    {
        try {
            global $wpdb;
            $tableName = $wpdb->prefix . self::$tableName;
            
            $result = $wpdb->get_results("SELECT * FROM $tableName ORDER BY ID DESC LIMIT $limit");
            
            $logs = array();
            foreach ($result as $key => $row) {
                array_push($logs, self::find($row->ID));
            }
            
            return $logs;
        } catch (Exception  $e){
            return array();
        }
    }

    public function save()
    {
        try {
            global $wpdb;
            $tableName = $wpdb->prefix . self::$tableName;
            
            $wpdb->get_results("
    			INSERT INTO $tableName (log_date, log_content) VALUES('$this->date', '$this->content')
    		");
        } catch (Exception  $e){}
    }
}