<?php

class UserModel extends AbstractModel{
    
    protected static $table = 'users';
    
    protected static $fields = 'login,salt,pass,role';
    
    protected static $plaseholders = ':login,:salt,:pass,:role';
    
    public static function 
            Factory($method_name, $plhld_array=NULL) 
    {
        switch ($method_name) 
        {
/* добавление пользователя */            
            case 'addUser':
                array_pop($plhld_array);
                self::$fields = '';
                self::$plaseholders = '';
                $cnt = count($plhld_array);
                foreach ($plhld_array as $k => $v) {
                    --$cnt; $f = ltrim($k, ':');
                    self::$fields .= (!$cnt) ? $f : ($f.',');             
                    self::$plaseholders .= (!$cnt) ? $k : ($k.',');
                }
                $query = 'INSERT INTO '.self::$table.
                    ' ('.self::$fields.') '
                    . 'VALUES('.self::$plaseholders.')';
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = $res ? 'категория успешно добавлена' : 'неверные данные';
                break;
                
/* выборка одного пользователя */
            case 'getUser':
                list($key,$val) = each($plhld_array);
                self::$where = ' WHERE '.$key.'='.$val;
                $query = 'SELECT '.self::$fields.' FROM '.self::$table.self::$where;
                return self::getOne($query);
            
                
/* редактирование пользователя */
            case 'editUser':
                $cnt = count($plhld_array); $plhld = ''; $fld = ''; $where = ''; $set = '';
                foreach ($plhld_array as $plhld => $v) {
                    --$cnt;
                    $fld = ltrim($plhld, ':');
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
                
/* удаление пользователя */    
            case 'deleteUser':
                if(!empty($plhld_array)){
                    list($key,$val) = each($plhld_array);
                    self::$where = ' WHERE id='.$key;
                }
                $query = 'DELETE FROM '.self::$table.self::$where;
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = ($res==TRUE) ? 'категория успешно удалена' : 'неверные данные';
                break;
            
/* выбрать всех пользователей из таблицы users*/
            default:
                $query = 'SELECT '.self::$fields.' FROM '.self::$table;
                return self::getAll($query);
        }
    }
}
