<?php

class FrontController {
    
    private $_controller;
    private $_action;
    private $_params = [];
    private static $instance;
    
    public static function getInstance() {
        if (!self::$instance instanceof self)
            self::$instance = new self;
        return self::$instance;
    }
    
    public function __construct() {
        $request = $_SERVER['REQUEST_URI'];
        $str = explode('/', trim($request,'/'));
        $this->_controller = !empty($str[0]) ? ucfirst($str[0]).'Controller' : 'UserController';
        $this->_action = !empty($str[1]) ? ucfirst($str[1]).'Action' : 'AllnewsAction';
        if(!empty($str[2])){
            $key = $val = [];
            for ($i = 2, $cnt=count($str); $i < $cnt; $i++) {
                if($i % 2 == 0){
                    $key[] = $str[$i];
                } else {
                    $val[] = $str[$i];
                }
            }
            $this->_params = array_combine($key, $val);
        }
    }
    
    public function route() {
        if(class_exists($this->getController())){
            $rc = new ReflectionClass($this->getController());
            if($rc->implementsInterface('IController')){
                if($rc->hasMethod($this->getAction())){
                    $object = $rc->newInstance();
                    $method = $rc->getMethod($this->getAction());
                    $method->isStatic() ? $method->invoke(NULL) : $method->invoke($object);
                } else {
                throw new Exception('Action');
                }
            } else {
            throw new Exception('Interface');
            }
        } else {
            throw new Exception('Controller');
        }
        
    }
    
    public function getController() {
        return $this->_controller;
    }
    
    public function getAction() {
        return $this->_action;
    }
    
    public function getParams() {
        return $this->_params;
    }
        
}
