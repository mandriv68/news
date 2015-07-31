<?php
class MyConfig {
    
    private static $config;
    
    public static function get() {
        if(!self::$config)
            self::$config = include __DIR__.'/../config.php';
        return self::$config;
    }
}
