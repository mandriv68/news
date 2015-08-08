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
            $this->handlerPOST();
//            VarDump::dump($this->_where);die;
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
        $this->_where['art_id'] = abs((int)$this->_fc->getParams()['id']);
        $item = NewsModel::Factory('getNews', $this->_where);
        if (!$item) {
            $_SESSION['msgs'] = 'по Вашему запросу ничего не найдено';
            $this->AllnewsAction();
        } else {
        $one = new ViewOneNews($item);
        $one->getBody();
        }
    }
        
    private function handlerPOST() 
    {
        foreach ($_POST as $k => $v) {
            if ($v){
                $this->_where[$k] = $v;
            }
        }
    }
}
