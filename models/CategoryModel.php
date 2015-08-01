<?php

class CategoryModel extends AbstractModel{
    protected static $table = 'categories';
    
    protected static $fields = 'cat_id AS id,cat_title AS title';
    
    protected static $plaseholders = ':id,:title';
    
    public static function Factory($method_name, $pl_holders_array=NULL) {
        switch ($method_name) {
            case 'addCategory':


                break;
            
            /* выбрать все категории из таблицы categories*/
            default:
                $query = 'SELECT '.self::$fields.' FROM '.self::$table;
                return self::getAll($query);
        }
    }
    
}
