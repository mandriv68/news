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
        unset($_SESSION['msgs']);
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $this->handlerPOST();
        }
        $search = [];
        $search['categories'] = CategoryModel::Factory('getAll');
        $items = NewsModel::Factory('getAll', $this->_where);
        if (!$items) {
            $_SESSION['msgs'] = 'по Вашему запросу ничего не найдено';
            $items = NewsModel::Factory('getAll', $this->_where = NULL);
        }
        $all = new ViewAllNews($search, $items);
        $all->getBody();
    }
    
    public function OnenewsAction() 
    {
        unset($_SESSION['msgs']);
        $this->_where['art_id'] = abs((int)$this->_fc->getParams()['id']);
        $item = NewsModel::Factory('getNews', $this->_where);
        if (!$item) {
            $_SESSION['msgs'] = 'по Вашему запросу ничего не найдено';
            $items = NewsModel::Factory('getAll', $this->_where = NULL);
            $all = new ViewAllNews($search, $items);
        } else {
        $one = new ViewOneNews($item);
        $one->getBody();
        }
    }
    
    protected function handlerPOST() {
        foreach ($_POST as $k => $v) {
            if ($v)
                $this->_where[$k] = $v;
        }
    }
}
