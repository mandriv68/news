<?php

class AdminController implements IController{
    
    private $_fc;

    public function __construct() 
    {
        $this->_fc = FrontController::getInstance();
        session_start();
    }
    
/* показать все новости, катгории на главной */ 
    public function  MainAction()
    {
        if (!isset($_SESSION['admin'])) {
            Secure::logIn();
        } else {
            $model = $this->_fc->getParams()['show'];
            if (!$model) $model = 'news';
            $model_name = (ucfirst($model).'Model');
            $items = $model_name::Factory('Main');
            if (!$items) { $_SESSION['res'] = 'Их нет у Нас, что-бы Вам показать'; }
            $view = new ViewAdmMain($items,$model);
            $view->getBody();
            unset($_SESSION['res']);
        }
    }
    
/* добавление и редактирование новости, категории */     
    public function SaveAction()
    {
        if (!isset($_SESSION['admin'])) {
            Secure::logIn();
        } else {
            $model = strtolower($this->_fc->getParams()['show']);
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                // проверяем заполнение обязательных полей
                if ($this->checkPOST($model)) {
                    $opt = $this->_fc->getParams()['opt'];
                    $this->save($opt,$model);
                } else {
                    $_SESSION['msgs'] = 'заполните все поля формы';
                }
            } 
                $categories = ($model == 'news') ? CategoryModel::Factory('getAll') : NULL;
                $item = $_POST ? (object)$_POST : $this->get($model);
                $view = new ViewAdmSave($item,$categories,$model);
                $view->getBody();
        }
    }
    
/* удаление новости, катгории */     
    public function DeleteAction()
    {
        if (!isset($_SESSION['admin'])) {
            Secure::logIn();
        } else {
            $model = $this->_fc->getParams()['show'];
            $model_name = (ucfirst($model).'Model');
            $method_name = 'delete'.ucfirst($model);
            if (array_key_exists('id', $this->_fc->getParams())){
                if ($model != 'user') 
                    $arr_placeholders[':id'] = abs((int)$this->_fc->getParams()['id']);
                else 
                    $arr_placeholders[':login'] = $this->_fc->getParams()['id'];
                $model_name::Factory($method_name,$arr_placeholders);
                header("Location:/admin/main/show/$model");
            } else {
                echo 'неверные данные для обработки'; die;
            }
        }
    }
/* закрытие сессии */
    public function LogoutAction() {
        session_destroy();
        header("Location:/admin/main");
        exit;
    }


/* сохранение данных из формы */
    private function save($method,$model)
    {
        $method_name = $method.ucfirst($model);
        $model_name = (ucfirst($model).'Model');
        $arr_placeholders = ($model != 'user') ? 
                $this->handlerAddForm() : $this->handlerUserForm();
        $res = $model_name::Factory($method_name,$arr_placeholders);
        if ($res)
            header("Location:/admin/main/show/$model");
        else 
            header("Location:/admin/add/show/$model");
    }
    
/* заполнить форму для редактирования данными из БД новости, катгории */     
    private function get($model) 
    {
        $method_name = 'get'.ucfirst($model);
        $model_name = (ucfirst($model).'Model');
        $arr_plhld['id'] = ($model != 'user') ? abs((int)$this->_fc->getParams()['id']) : $this->_fc->getParams()['id'];
        if($arr_plhld['id']==0) 
             return NULL;
        else return $model_name::Factory($method_name,$arr_plhld);
    }


/* обработчик формы */
    private function  handlerAddForm()
    {
        $place_array = [];
        foreach ($_POST as $key => $value) {
            if ($value == 'hidden') continue;
            else $place_array[':'.$key] = $value;
        }
        return $place_array;
    }

/* обработчик формы пользователей */
    private function handlerUserForm() 
    {
        $arr = new HandlerUserForm($_POST);
        $place_array = $arr->getPlaceholdersArr();
        return $place_array;
    }

/* проверяем заполнения обязательных полей формы*/
    private function checkPOST($model) {
        $res = '';
        switch ($model) {
            case 'news':
                return $res = (!empty($_POST['title'])&&!empty($_POST['description'])&&!empty($_POST['txt'])&&!empty($_POST['author'])) ? TRUE : FALSE;
            case 'category':
                return $res = (!empty($_POST['title'])&&!empty($_POST['description'])) ? TRUE : FALSE;
            case 'user':
                return $res = (!empty($_POST['login'])&&!empty($_POST['pass'])&&!empty($_POST['role'])) ? TRUE : FALSE;
        }
    }
    
}
