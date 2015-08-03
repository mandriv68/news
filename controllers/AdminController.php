<?php

class AdminController implements IController{
    
    private $_fc;

    public function __construct() 
    {
        $this->_fc = FrontController::getInstance();
    }
    
    public function MainAction()
    {
        $items = AdminModel::Factory('Main',NULL);
        $view = new ViewAdmMain($items);
        $view->getBody();
        unset($_SESSION['res']);
    }
    
    public function AddnewsAction()
    {
        unset($_SESSION['msgs']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!empty($_POST['title'])&&!empty($_POST['description'])&&!empty($_POST['text'])&&!empty($_POST['author'])) {
                $this->save('addNews');
            } else {
                $_SESSION['msgs'] = 'заполните все поля формы';
                goto view_adm_add;
            }
        } else {
            view_adm_add:     // метка перехода
            $categories = CategoryModel::Factory('getAll');
            $news = $_POST ? (object)$_POST : NULL;
            $view = new ViewAdmSave($categories,$news);
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
            $arr_placeholders[':id'] = abs((int)$this->_fc->getParams()['id']);
            $news = $_POST ? (object)$_POST : AdminModel::Factory('getNews',$arr_placeholders);
            $view = new ViewAdmSave($categories,$news);
            $view->getBody();
        }
    }
    
    public function DelitenewsAction()
    {
        if (array_key_exists('id', $this->_fc->getParams())){
            $arr_placeholders[':id'] = abs((int)$this->_fc->getParams()['id']);
            AdminModel::Factory('deleteNews',$arr_placeholders);
            header("Location:/admin/main");
        } else {
            echo 'неверные данные для обработки'; die;
        }
    }
    
    /* сохранение данных из формы */
    public function save($method_name)
    {
        $arr_placeholders = $this->handlerAddForm();
        AdminModel::Factory($method_name,$arr_placeholders);
        header("Location:/admin/main");
    }
    
    /* обработчик формы */
    public function handlerAddForm()
    {
        $place_array = [];
        foreach ($_POST as $key => $value) {
                $place_array[':'.$key] = $value;
        }
        return $place_array;
    }
    
}
