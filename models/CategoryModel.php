<?php

class CategoryModel extends AbstractModel{
    protected static $table = 'categories';
    
    protected static $fields = 'cat_id AS id,cat_title AS title,cat_description as description';
    
    protected static $plaseholders = ':id,:title,:description';
    
    public static function 
            Factory($method_name, $plhld_array=NULL) 
    {
        switch ($method_name) 
        {
/* добавление категории */            
            case 'addCategory':
                array_pop($plhld_array);
                self::$fields = '';
                self::$plaseholders = '';
                $cnt = count($plhld_array);
                foreach ($plhld_array as $k => $v) {
                    --$cnt; $f = 'cat_'.ltrim($k, ':');
                    self::$fields .= (!$cnt) ? $f : ($f.',');             
                    self::$plaseholders .= (!$cnt) ? $k : ($k.',');
                }
                $query = 'INSERT INTO '.self::$table.
                    ' ('.self::$fields.') '
                    . 'VALUES('.self::$plaseholders.')';
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = $res ? 'категория успешно добавлена' : 'неверные данные';
                break;
                
/* выборка одной категории */
            case 'getCategory':
                list($key,$val) = each($plhld_array);
                self::$where = ' WHERE '.$key.'='.$val;
                $query = 'SELECT '.self::$fields.' FROM '.self::$table.self::$where;
                return self::getOne($query);
            
                
/* редактирование категории */
            case 'editCategory':
                $cnt = count($plhld_array); $plhld = ''; $fld = ''; $where = ''; $set = '';
                foreach ($plhld_array as $plhld => $v) {
                    --$cnt;
                    $fld = 'cat_'.ltrim($plhld, ':');
                    if (!$cnt) {
                        $where = $fld.'='.$plhld;
                    } else {
                        $set .= $fld.'='.$plhld.',';
                    }
                }
                $query = 'UPDATE '.self::$table.' SET '.rtrim($set,",").' WHERE '.$where;
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = ($res==TRUE) ? 'категория успешно обновлена' : 'неверные данные';
                break;
                
/* удаление категории */    
            case 'deleteCategory':
                if(!empty($plhld_array)){
                    list($key,$val) = each($plhld_array);
                    self::$where = ' WHERE cat_id='.$key;
                }
                $query = 'DELETE FROM '.self::$table.self::$where;
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = ($res==TRUE) ? 'категория успешно удалена' : 'неверные данные';
                break;
            
/* выбрать все категории из таблицы categories*/
            default:
                $query = 'SELECT '.self::$fields.' FROM '.self::$table;
                return self::getAll($query);
        }
    }
    
}
