<?php

class NewsModel extends AbstractModel{
    
    protected static $table = 'articles';
    protected static $fields = 'art_id AS id,art_title AS title,art_description AS description,art_text AS text,art_author AS author,art_datetime AS datetime,art_category AS category';
    protected static $placeholders = '';

    public static function Factory($method_name, $plhld_array) 
    {
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
                    --$cnt;
                    $fld = 'art_'.ltrim($plhld, ':');
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
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = $res ? 'новость успешно добавлена' : 'неверные данные';
                break;
            
/* показать все новости */
            default:
                self::$where = self::handlerInputData($plhld_array);
                $query = 'SELECT '.self::$fields.' FROM '.self::$table.self::$where;
                return self::getAll($query);
        }
    }
    
/* обработчик входных данных из Search */
    protected static function handlerInputData($arr) 
    {
        $where = '';
        if (!$arr) return $where;
        while (list($key,$val) = each($arr)) {
            $pos = strpos($where, 'WHERE');
            switch ($key) {
                case 'category': 
                    $where .= ' WHERE art_'.$key.'='.$val; break;
                case 'from_date':
                    $where .= ($pos===FALSE) ? (' WHERE art_datetime >= '.self::mkTime($val)) : (' AND art_datetime >= '.self::mkTime($val)); break;
                case 'by_date':
                    $where .= ($pos===FALSE) ? (' WHERE art_datetime <= '.  self::mkTime($val)) : (' AND art_datetime <= '.self::mkTime($val)); break;
                case 'author':
                    $where .= ($pos===FALSE) ? (' WHERE LOWER(art_'.$key.') LIKE \'%'.strtolower($val).'%\'') : (' AND LOWER(art_'.$key.') LIKE \'%'.strtolower($val).'%\''); break;
            }
        }
        return $where;
    }

/* преобразование даты в формат UNIX */
    protected static function mkTime($d) 
    {
        $date = explode('-', $d);
        return mktime(0, 0, 0, $date[1], $date[0], $date[2]);
    }
}
