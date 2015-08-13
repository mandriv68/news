<?php

class UserModel extends AbstractModel{
    
    protected static $table = 'users';
    
    protected static $fields = 'login,salt,iteration,pass,role';
    
    protected static $plaseholders = ':login,:salt,:iteration,:pass,:role';
    
    public static function 
            Factory($method_name, $plhld_array=NULL) 
    {
        switch ($method_name) 
        {
/* добавление пользователя */            
            case 'addUser':
                self::$fields = '';
                self::$plaseholders = '';
                foreach ($plhld_array as $k => $v) {
                    $f = ltrim($k, ':');
                    self::$fields .= $f.',';             
                    self::$plaseholders .= $k.',';
                }
                $query = 'SELECT * FROM '.self::$table.' WHERE login=\''.$plhld_array[':login'].'\' LIMIT 1';
                $result = DBconnect::getInstance()->query($query);
                if (!$result) {
                    $query = 'INSERT INTO '.self::$table.
                        ' ('. rtrim(self::$fields, ',') .') '
                        . 'VALUES('. rtrim(self::$plaseholders, ',') .')';
                    $res = self::saveANDdelete($query, $plhld_array);
                    $_SESSION['res'] = $res ? 'пользователь добавлен' : 'неверные данные';
                    return TRUE;
                } else {
                    $_SESSION['msgs'] = 'такой пользователь уже существует';
                    return FALSE;
                }
                break;
                
/* выборка одного пользователя */
            case 'getUser':
                VarDump::dump($plhld_array);
                self::$where = ' WHERE login=\''.$plhld_array['id'].'\'';
                $query = 'SELECT '.self::$fields.' FROM '.self::$table.self::$where;
//                VarDump::dump($query);die;
                return self::getOne($query);
            
                
/* редактирование пользователя */
            case 'editUser':
                $set = '';
                $set_arr = array_combine(explode(',', self::$fields), explode(',', self::$plaseholders));
                foreach ($set_arr as $f=>$p){
                    $set .= $f.'='.$p.',';
                }
                $where = 'login=\''.$plhld_array[':login'].'\'';
                $query = 'UPDATE '.self::$table.' SET '.rtrim($set,",").' WHERE '.$where;
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = ($res==TRUE) ? 'пользователь обновлен' : 'неверные данные';
                return $res;
                break;
                
/* удаление пользователя */    
            case 'deleteUser':
                if(!empty($plhld_array)){
                    list($key,$val) = each($plhld_array);
                    self::$where = ' WHERE login=:login';
                }
                $query = 'DELETE FROM '.self::$table.self::$where;
                $res = self::saveANDdelete($query, $plhld_array);
                $_SESSION['res'] = ($res==TRUE) ? 'пользователь удален' : 'неверные данные';
                break;
            
/* выбрать всех пользователей из таблицы users*/
            default:
                $query = 'SELECT '.self::$fields.' FROM '.self::$table;
                return self::getAll($query);
        }
    }
}
