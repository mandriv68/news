<?php

class AbstractModel {
    protected static $dbh;
    protected static $fields;
    protected static $class;
    protected static $plaseholders;
    
    public static function getClass() {
        return static::$class = get_called_class();
    }


    /* пользовательская часть */
    
    public static function getAll($query) {
        return DBconnect::getInstance()->fetchAll($query, self::getClass());
    }
    
    public static function getOne($query) {
        return DBconnect::getInstance()->fetchObj($query, self::getClass());
    }
    
    /* административная часть */
    
    public static function saveANDdelete($query,$pl_holders_array) {
        return DBconnect::getInstance()->execute($query,$pl_holders_array);
    }
    
}
