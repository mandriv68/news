<?php

class AdminModel extends AbstractModel{
    
    protected static $table = 'articles';
    
//    protected static $fields = 'art_title,art_description,art_text,art_author,art_datetime,art_category';
    
//    protected static $plaseholders = ':title,:description,:text,:author,:datetime,:category';
    
    public static function Factory($method_name, $pl_holders_array)
    {
        switch ($method_name) {
            
            /* добавление новости */
            case 'addNews':
                array_pop($pl_holders_array);
                $cnt = count($pl_holders_array);
                foreach ($pl_holders_array as $k => $v) {
                    --$cnt; $f = ltrim($k, ':');
                    self::$fields .= (!$cnt) ? ('art_'.$f) : ('art_'.$f.',');             
                    self::$plaseholders .= (!$cnt) ? $k : ($k.',');
                }
//                VarDump::dump(self::$fields);
//                VarDump::dump(self::$plaseholders);die;
                $query = 'INSERT INTO '.self::$table.
                    ' ('.self::$fields.') '
                    . 'VALUES('.self::$plaseholders.')';
                $res = self::saveANDdelete($query, $pl_holders_array);
                $_SESSION['res'] = $res ? 'новость успешно добавлена' : 'неверные данные';
                break;
            
            /* редактирование новости */
            case 'editNews':
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
                self::$fields = 'art_id AS id,'
                          . 'art_title AS title,'
                          . 'art_description AS description,'
                          . 'art_text AS text,'
                          . 'art_author AS author,'
                          . 'art_datetime AS datetime,'
                          . 'cat_title AS cat';
                $query = 'SELECT '.self::$fields.
                        ' FROM '.self::$table.
                        ' WHERE art_id='.$pl_holders_array[':id'].
                        ' AND categories.cat_id=articles.art_category';
                return self::getOne($query);
                        
            /* все новости на главной странице админки */
            default :
                self::$fields = 'art_id AS id,art_title AS title,art_description AS description';
                $query = 'SELECT '.static::$fields.' FROM '.static::$table;
                return self::getAll($query);
        }
    }
        
}
