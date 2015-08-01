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
                unset($_POST);
                goto view_adm_add;
            }
        } else {
            view_adm_add:     // метка перехода
            $categories = AdminModel::Factory('getAllCategories',NULL);
            $view = new ViewAdmAdd($categories);
            $view->getBody();
        }
    }
        
    public function EditnewsAction()
    {
        unset($_SESSION['msgs']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!empty($_POST['title'])&&!empty($_POST['description'])&&!empty($_POST['text'])&&!empty($_POST['author'])) {
                $this->save('editNews',$_SESSION['id']);
            } else {
                $_SESSION['msgs'] = 'заполните все поля формы';
                unset($_POST);
                goto view_adm_edit;
            }
        } else {
            view_adm_edit:     // метка перехода
            $categories = AdminModel::Factory('getAllCategories',NULL);
            $_SESSION['id'] = abs((int)$this->_fc->getParams()['id']);
            $news = AdminModel::Factory('getNews',NULL, $_SESSION['id']);
            $view = new ViewAdmEdit($categories,$news);
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
    public function save($method_name,$id=NULL)
    {
        $post = &$_POST;
        $arr_placeholders = $this->handlerAddForm($post);
        AdminModel::Factory($method_name,$arr_placeholders,$id);
        header("Location:/admin/main");
    }
    
    /* обработчик формы */
    public function handlerAddForm($post)
    {
        $place_array = [];
        $cnt = count($post)-1;$i = 0;
        foreach ($post as $key => $value) {
            if($i<$cnt){
                $ph = ':'.$key;
                $place_array[$ph] = $value;
                $i++;
            } else break;
        }
        return $place_array;
    }
    
}
