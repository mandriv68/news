<?php

class AdminModel extends AbstractModel{
    
    protected static $table = 'articles';
    
    protected static $fields = 'art_title,art_description,art_text,art_author,art_datetime,art_category';
    
    protected static $plaseholders = ':title,:description,:text,:author,:datetime,:category';
    
    public static function Factory($method_name, $pl_holders_array, $id=NULL)
    {
        switch ($method_name) {
            /* добавление новости */
            case 'addNews':
                $query = 'INSERT INTO '.self::$table.
                    ' ('.self::$fields.') '
                    . 'VALUES('.self::$plaseholders.')';
                $res = self::saveANDdelete($query, $pl_holders_array);
                $_SESSION['res'] = $res ? 'новость успешно добавлена' : 'неверные данные';
                break;
            /* редактирование новости */
            case 'editNews':
                $pl_holders_array[':id'] = $id;
                $fld = explode(',', self::$fields);
                $plhld = explode(',', self::$plaseholders);
                $arr = array_combine($fld, $plhld);
                $set = ''; $i=0;
                foreach ($arr as $key => $value) {
                    if ($i==  (count($arr)-1)) $set .= "$key=$value";
                    else $set .= "$key=$value,";
                    $i++;
                }
                $query = 'UPDATE '.self::$table.
                        ' SET '.$set.
                        ' WHERE art_id=:id';
                $res = self::saveANDdelete($query, $pl_holders_array);
                $_SESSION['res'] = ($res==TRUE) ? 'новость успешно обновлена' : 'неверные данные';
                break;
            /* удаление новости */    
            case 'deleteNews':
                self::$plaseholders = ':id';
                $query = 'DELETE FROM '.self::$table.
                        ' WHERE art_id='.self::$plaseholders;
                $res = self::saveANDdelete($query, $pl_holders_array);
                $_SESSION['res'] = ($res==TRUE) ? 'новость успешно удалена' : 'неверные данные';
                break;
            
            /* извлечение новости из таблицы */
            case 'getNews':
                self::$table = 'articles,categories';
                self::$fields = 'art_title AS title,'
                          . 'art_description AS description,'
                          . 'art_text AS text,'
                          . 'art_author AS author,'
                          . 'art_datetime AS datetime,'
                          . 'cat_title AS cat';
                $query = 'SELECT '.static::$fields.
                        ' FROM '.static::$table.
                        ' WHERE art_id='.$id.
                        ' AND categories.cat_id=articles.art_category';
                return self::getOne($query);
                
            /* выбрать все категории из таблицы categories*/
            case 'getAllCategories':
                self::$table = 'categories';
                self::$fields = 'cat_id,cat_title';
                $query = 'SELECT '.static::$fields.' FROM '.static::$table;
                return self::getAll($query);
            /* все новости на главной странице админки */
            default :
                self::$fields = 'art_id,art_title,art_description';
                $query = 'SELECT '.static::$fields.' FROM '.static::$table;
                return self::getAll($query);
                break;
        }
        
    }
}
