<?php

class AdminModel extends AbstractModel{
    
    protected static $table = 'articles';
    
//    protected static $fields = 'art_title,art_description,art_text,art_author,art_datetime,art_category';
//    
//    protected static $plaseholders = ':title,:description,:text,:author,:datetime,:category';
//    
    public static function Factory($method_name, $pl_holders_array)
    {
        switch ($method_name) {
            
            /* добавление новости */
            case 'addNews':
                array_pop($pl_holders_array);
                $cnt = count($pl_holders_array);
                foreach ($pl_holders_array as $k => $v) {
                    --$cnt; $f = 'art_'.ltrim($k, ':');
                    self::$fields .= (!$cnt) ? $f : ($f.',');             
                    self::$plaseholders .= (!$cnt) ? $k : ($k.',');
                }
                $query = 'INSERT INTO '.self::$table.' ('.self::$fields.') VALUES('.self::$plaseholders.')';
                $res = self::saveANDdelete($query, $pl_holders_array);
                $_SESSION['res'] = $res ? 'новость успешно добавлена' : 'неверные данные';
                break;
            
            /* редактирование новости */
            case 'editNews':
                $cnt = count($pl_holders_array); $plhld = ''; $fld = ''; $where = ''; $set = '';
                foreach ($pl_holders_array as $plhld => $v) {
                    --$cnt; $fld = 'art_'.ltrim($plhld, ':');
                    if (!$cnt) {
                        $where = $fld.'='.$plhld;
                    } else {
                        $set .= $fld.'='.$plhld.',';
                    }
                }
                $query = 'UPDATE '.self::$table.' SET '.rtrim($set,",").' WHERE '.$where;
                $res = self::saveANDdelete($query, $pl_holders_array);
                $_SESSION['res'] = ($res==TRUE) ? 'новость успешно обновлена' : 'неверные данные';
                break;
                
            /* удаление новости W*/    
            case 'deleteNews':
                self::$plaseholders = ':id';
                $query = 'DELETE FROM '.self::$table.' WHERE art_id='.self::$plaseholders;
                $res = self::saveANDdelete($query, $pl_holders_array);
                $_SESSION['res'] = ($res==TRUE) ? 'новость успешно удалена' : 'неверные данные';
                break;
            
            /* извлечение новости из таблицы W*/
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
                        
            /* все новости на главной странице админки W*/
            default :
                self::$fields = 'art_id AS id,art_title AS title,art_description AS description';
                $query = 'SELECT '.self::$fields.' FROM '.self::$table;
                return self::getAll($query);
        }
    }
        
}
