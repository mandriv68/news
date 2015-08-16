<?php

class Secure {


    public static function logIn($msgs = NULL) 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!empty($_POST['login']) && !empty($_POST['pass'])) {
                $res = self::handlerPOST();
                if ($res === TRUE){
                    session_start();
                    $_SESSION['user'] = str_rot13($_POST['login']);
                    $_SESSION['privileg'] = $_POST['role'];
                    $_SESSION['res'] = 'Вы с нами';
                    header("Location:/admin/main");
                }
            }
        } else echo 'НЕ POST';
        if ($_SESSION['user']) {
/* проверяем, есть-ли такой пользователь */
            $user = UserModel::existsUser(str_rot13($_SESSION['user']));
            if ($user) {
                $view = new ViewAdmMain();
                $view->getBody();
            } else {
                $msgs = 'неверная авторизация';
                $this->logIn($msgs);
            }
        }  else            echo 'НЕ SESSION[USER]'; 
        if (!$msgs) $msgs = 'Пройдите авторизацию';
        $view = new ViewAdminLogin($msgs);
        $view->getBody();
    }
    
    private static function handlerPOST() {
        $login = $_POST['login'];
        $user = UserModel::existsUser($login);
        if (!$user) {
            $msgs = 'Вы не авторизовались, повторите попытку';
            self::logIn($msgs);
        }
        $res = self::checkPass($user);
        if ($res === $user['pass'])
            return TRUE;
        else {
            $msgs = 'неверная авторизация';
            self::logIn($msgs);
        }
    }
    
    private static function checkPass($user) 
    {
        $pass = '';
        $it = $user['iteration'];
        $salt = $user['salt'];
        $psw = $_POST['pass'];
        for ($i = 0; $i < $it; $i++) {
            $pass = sha1($salt.$psw);
        }
        return $pass;
    }
}
