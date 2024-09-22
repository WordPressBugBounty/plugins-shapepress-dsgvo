<?php

class SPDSGVOMigrator
{

    private static $instance;

    private static $migrationJobs = array('3.0.0' => '300', '3.1.0' => '30100',);

    public function __construct()
    {
    }


    public static function init()
    {
        return new self;
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    public function checkForMigrations()
    {
        $this->doMigrations();
    }

    public function doMigrations()
    {
        // check the last version
        $lastVersion = SPDSGVOSettings::get('plugin_version');
        $currentVersion = sp_dsgvo_VERSION;
        $migrationHistory = SPDSGVOSettings::get('migration_history');
        if (isset($migrationHistory) == false || is_array($migrationHistory) == false) {
            $migrationHistory = [];
        }

        /*
        if (array_key_exists(sp_dsgvo_VERSION, self::$migrationJobs) == false) {
            // only set version
            SPDSGVOSettings::set('plugin_version', sp_dsgvo_VERSION);
            return;
        }
        */

        foreach (self::$migrationJobs as $key => $value) {
            if (in_array($key, $migrationHistory) == false) {
                $methodNameOfMigration = 'upgrade_' . str_replace('.', '', sp_dsgvo_VERSION);
                if (method_exists(self::getInstance(), $methodNameOfMigration)) {
                    call_user_func(array(self::getInstance(), $methodNameOfMigration));
                    $migrationHistory[] = $key;
                    SPDSGVOSettings::set('migration_history', $migrationHistory); // always save after an successfull job
                }
            }
        }

        // inc version for next time update
        SPDSGVOSettings::set('plugin_version', sp_dsgvo_VERSION);
        SPDSGVOSettings::set('migration_history', $migrationHistory);

    }

    public function upgrade_300()
    {
        // set tracker settings to new objects
    }

    public function upgrade_30100()
    {
        error_log('upgrade_30100');
    }
}