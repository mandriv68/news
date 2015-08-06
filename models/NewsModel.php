<?php

class NewsModel extends AbstractModel{
    
    protected static $table = 'articles';
    protected static $fields = 'art_id AS id,art_title AS title,art_description AS description,art_text AS text,art_author AS author,art_datetime AS datetime,art_category AS category';
    protected static $placeholders = '';
    protected static $where = '';

        public static function Factory($method_name, $plhld_array) {
        
        switch ($method_name) {
/* выборка одной новости */
            case 'getNews':
                self::$table .= ',categories';
                self::$fields .= ',cat_title AS cat';
                list($key,$val) = each($plhld_array);
                self::$where = ' WHERE '.$key.'='.$val;
                self::$where .= ' AND categories.cat_id=articles.art_category';
                $query = 'SELECT '.self::$fields.' FROM '.self::$table.self::$where;
                return self::getOne($query);
                break;
            
/* удаление новости */    
            case 'deleteNews':
                if(!empty($plhld_array)){
                    list($key,$val) = each($plhld_array);
                    self::$where = ' WHERE art_id='.$key;
                }
                $query = 'DELETE FROM '.self::$table.self::$where;
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = ($res==TRUE) ? 'новость успешно удалена' : 'неверные данные';
                break;
                
/* редактирование новости */
            case 'editNews':
                $cnt = count($plhld_array); $plhld = ''; $fld = ''; $where = ''; $set = '';
                foreach ($plhld_array as $plhld => $v) {
                    --$cnt; $fld = 'art_'.ltrim($plhld, ':');
                    if (!$cnt) {
                        $where = $fld.'='.$plhld;
                    } else {
                        $set .= $fld.'='.$plhld.',';
                    }
                }
                $query = 'UPDATE '.self::$table.' SET '.rtrim($set,",").' WHERE '.$where;
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = ($res==TRUE) ? 'новость успешно обновлена' : 'неверные данные';
                break;
                
/* добавление новости */
            case 'addNews':
                array_pop($plhld_array);
                self::$fields = '';
                $cnt = count($plhld_array);
                foreach ($plhld_array as $k => $v) {
                    --$cnt; $f = 'art_'.ltrim($k, ':');
                    self::$fields .= (!$cnt) ? $f : ($f.',');             
                    self::$plaseholders .= (!$cnt) ? $k : ($k.',');
                }
                $query = 'INSERT INTO '.self::$table.' ('.self::$fields.') VALUES('.self::$plaseholders.')';
//                VarDump::dump($plhld_array);VarDump::dump($query);die;
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = $res ? 'новость успешно добавлена' : 'неверные данные';
                break;
            
/* показать все новости */
            default:
                if(!empty($plhld_array)){
                    list($key,$val) = each($plhld_array);
                    self::$where = ' WHERE '.$key.'='.$val;
                }
                $query = 'SELECT '.self::$fields.' FROM '.self::$table.self::$where;
                return self::getAll($query);
        }
    }
    
    protected static function handlerWhere($param) {
        $where = ' WHERE ';
    }
}
