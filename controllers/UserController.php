<?php

class UserController implements IController{
    
    private $_fc;
    private $_where = [];
    
    public function __construct()
    {
        $this->_fc = FrontController::getInstance();
    }

    public function AllnewsAction()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            var_dump($_POST['category']);
            if ($_POST['category'] !=NULL)
                $this->_where['art_category'] = abs((int)$_POST['category']);
        }
        $search = [];
        $search['categories'] = CategoryModel::Factory('getAll');
        $items = UserModel::Factory('getAll', $this->_where);
        $all = new ViewAllNews($search, $items);
        $all->getBody();
    }
    
    public function OnenewsAction() 
    {
        $this->_where['art_id'] = abs((int)$this->_fc->getParams()['id']);
        $item = UserModel::Factory('getOne', $this->_where);
        $one = new ViewOneNews($item);
        $one->getBody();
    }
    
    public function SearchAction() {
        $item = '';
    }
    
}
