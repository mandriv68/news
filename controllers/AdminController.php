<?php

class AdminController implements IController{
    
    private $_fc;

    public function __construct() 
    {
        $this->_fc = FrontController::getInstance();
    }
    
    public function MainAction()
    {
        $model = $this->_fc->getParams()['show'];
        if (!$model) $model = 'news';
        $model_name = (ucfirst($model).'Model');
        $items = $model_name::Factory('Main',NULL);
//        switch ($model) {
//            case 'category':$this->_marker = 'category'; break;
//            case 'user' :   $this->_marker = 'user'; break;
//            default:        $this->_marker = 'news'; break;
//        }
        $view = new ViewAdmMain($items,$model);
        $view->getBody();
        unset($_SESSION['res']);
    }
    
    public function AddAction()
    {
        $model = $this->_fc->getParams()['show'];
        unset($_SESSION['msgs']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!empty($_POST['title'])&&!empty($_POST['description'])&&!empty($_POST['text'])&&!empty($_POST['author'])) {
                $this->save('addNews',$model);
            } else {
                $_SESSION['msgs'] = 'заполните все поля формы';
                goto view_adm_add;
            }
        } else {
            view_adm_add:     // метка перехода
            $categories = ($model == 'news') ? CategoryModel::Factory('getAll') : NULL;
            $item = $_POST ? (object)$_POST : NULL;
            $view = new ViewAdmSave($item,$categories,$model);
            $view->getBody();
        }
    }
        
    public function EditnewsAction()
    {
        unset($_SESSION['msgs']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!empty($_POST['title'])&&!empty($_POST['description'])&&!empty($_POST['text'])&&!empty($_POST['author'])) {
                $this->save('editNews');
            } else {
                $_SESSION['msgs'] = 'заполните все поля формы';
                goto view_adm_edit;
            }
        } else {
            view_adm_edit:     // метка перехода
            $categories = CategoryModel::Factory('getAll');
            $arr_placeholders['art_id'] = abs((int)$this->_fc->getParams()['id']);
            $news = $_POST ? (object)$_POST : NewsModel::Factory('getNews',$arr_placeholders);
            $view = new ViewAdmSave($categories,$news);
            $view->getBody();
        }
    }
    
    public function DelitenewsAction()
    {
        if (array_key_exists('id', $this->_fc->getParams())){
            $arr_placeholders[':id'] = abs((int)$this->_fc->getParams()['id']);
            NewsModel::Factory('deleteNews',$arr_placeholders);
            header("Location:/admin/main");
        } else {
            echo 'неверные данные для обработки'; die;
        }
    }
    
    /* сохранение данных из формы */
    public function save($method_name,$model)
    {
        $model_name = (ucfirst($model).'Model');
        $arr_placeholders = $this->handlerAddForm();
        VarDump::dump($arr_placeholders);die;
        $model_name::Factory($method_name,$arr_placeholders);
        header("Location:/admin/main/show/$model");
    }
    
    /* обработчик формы */
    public function handlerAddForm()
    {
        $place_array = [];
        foreach ($_POST as $key => $value) {
            if ($value == 'hidden') continue;
            else $place_array[':'.$key] = $value;
        }
        return $place_array;
    }
    
}
