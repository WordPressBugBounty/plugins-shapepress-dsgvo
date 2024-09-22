<?php

class SPDSGVOCacheManager
{

    public static function clearCaches()
    {
        try {

            // clear autoptimize
            if (class_exists('autoptimizeCache')) {
                if (function_exists('autoptimizeCache')) {
                    autoptimizeCache::clearall();
                }
            }

            // Clear Litespeed cache
            method_exists('LiteSpeed_Cache_API', 'purge_all') && LiteSpeed_Cache_API::purge_all();

            // WP Super Cache
            if (function_exists('wp_cache_clear_cache'))
            {
                wp_cache_clear_cache();
            }
            // W3 Total Cache
            if (function_exists('w3tc_pgcache_flush'))
            {
                w3tc_pgcache_flush();
            }
            // Site Ground Cache
            if (class_exists('SG_CachePress_Supercacher') && method_exists('SG_CachePress_Supercacher ', 'purge_cache'))
            {
                SG_CachePress_Supercacher::purge_cache(true);
            }
            // Endurance Cache
            if (class_exists('Endurance_Page_Cache'))
            {
                $e = new Endurance_Page_Cache;
                $e->purge_all();
            }
            // WP Fastest Cache
            if (isset($GLOBALS['wp_fastest_cache']) && method_exists($GLOBALS['wp_fastest_cache'], 'deleteCache'))
            {
                $GLOBALS['wp_fastest_cache']->deleteCache(true);
            }

        } catch (Exception $e) {
        }
    }
}