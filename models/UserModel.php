<?php

class UserModel extends AbstractModel{
    
    protected static $table = 'articles';
    protected static $fields = 'art_id AS id,art_title AS title,art_description AS description,art_text AS text,art_author AS author,art_datetime AS datetime,art_category AS category';
    protected static $where = '';

        public static function Factory($method_name,$where)
    {
        switch ($method_name) {
            /* показать одну новость */
            case 'getOne':
                self::$table .= ',categories';
                self::$fields .= ',cat_title AS cat';
                list($key,$val) = each($where);
                self::$where = $key.'='.$val;
            $query = 'SELECT '.self::$fields.' FROM '.self::$table.' WHERE '.self::$where.' AND categories.cat_id=articles.art_category';
            return self::getOne($query);
            /* показать все новости */
            default:
                if(!empty($where)){
                    list($key,$val) = each($where);
                    self::$where = ' WHERE '.$key.'='.$val;
                }
                $query = 'SELECT '.self::$fields.' FROM '.self::$table.self::$where;
                return self::getAll($query);
        }
    }
}
