<?php

class CategoryModel extends AbstractModel{
    protected static $table = 'categories';
    
    protected static $fields = 'cat_id AS id,cat_title AS title,cat_description as description';
    
    protected static $plaseholders = ':id,:title,:description';
    
    public static function Factory($method_name, $pl_holders_array=NULL) {
        switch ($method_name) {
            
            case 'addCategory':
                $query = 'INSERT INTO '.self::$table.
                    ' ('.self::$fields.') '
                    . 'VALUES('.self::$plaseholders.')';
                $res = self::saveANDdelete($query, $pl_holders_array);
                $_SESSION['res'] = $res ? 'категория успешно добавлена' : 'неверные данные';
                break;
            
            /* выбрать все категории из таблицы categories*/
            default:
                $query = 'SELECT '.self::$fields.' FROM '.self::$table;
                return self::getAll($query);
        }
    }
    
}
