<?php

class Secure {
    
    private static $msgs;
    private static $user;

    public static function logIn($msgs = NULL) 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!empty($_POST['login']) && !empty($_POST['pass'])) {
                $res = self::handlerPOST();
                if ($res){
                    session_start();
                    $_SESSION['user'] = str_rot13(self::$user['login']);
                    $_SESSION['privileg'] = self::$user['role'];
                    $_SESSION['res'] = 'Успешная авторизация';
                    header("Location:/admin/main");
                }
            } else self::$msgs = 'введите логин и пароль';
        } else echo 'НЕ POST';
//        if ($_SESSION['user']) {
///* проверяем, есть-ли такой пользователь */
//            $user = UserModel::existsUser(str_rot13($_SESSION['user']));
//            if ($user) {
//                return true;
//            } else {
//                self::$msgs = 'неверная авторизация';
//                return false;
//            }
//        }  // else  return false; 
        if (!self::$msgs) self::$msgs = 'Пройдите авторизацию';
        $view = new ViewAdminLogin(self::$msgs);
        $view->getBody();
    }
    
    private static function handlerPOST() {
        $login = trim(strip_tags($_POST['login']));
        self::$user = UserModel::existsUser($login);
        VarDump::dump(self::$user);
        if (!self::$user) {
            self::$msgs = 'Вы не авторизовались, повторите попытку';
//            self::logIn($msgs);
            return FALSE;
        }
        $password = self::checkPass(self::$user);
        VarDump::dump($password);
        if (self::$user['pass'] == $password)
            return TRUE;
        else {
            self::$msgs = 'неверная авторизация';
//            self::logIn($msgs);
            return FALSE;
        }
    }
    
    private static function checkPass($user) 
    {
        $pass = '';
        $it = $user['iteration'];
        $salt = $user['salt'];
        $psw = $_POST['pass'];
        for ($i = 0; $i < $it; $i++) {
            $pass = sha1($psw.$salt);
        }
        VarDump::prnt($pass);die;
        return $pass;
    }
}
