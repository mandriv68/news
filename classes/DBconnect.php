<?php

class DBconnect {
    private $_configDB;
    private static $_instance;
    private $_opt;
    private $_dsn;
    private $_pdo;
    
    public static function getInstance() {
        if(!self::$_instance instanceof self)
            self::$_instance = new self;
        return self::$_instance;
    }

    private function __construct() {
        $this->_configDB = MyConfig::get()['db'];
        $this->_dsn = "mysql:host=".$this->_configDB['host'].
                         ";dbname=".$this->_configDB['dbname'];
        $this->_opt = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,];
        $this->_pdo = new PDO($this->_dsn,
                                    $this->_configDB['login'],
                                    $this->_configDB['password'],
                                    $this->_opt);
    }
    
    public function fetchAll($query,$class='stdclass') {
        $stmt = $this->_pdo->query($query);
        $res = $stmt->fetchAll(PDO::FETCH_CLASS,$class);
        if (!$res) echo 'нет данных для вывода';
        else  return $res;
    }
    
    public function fetchObj($query,$class='stdclass') {
        $stmt = $this->_pdo->query($query);
        $res = $stmt->fetchObject($class);
        if (!$res) echo 'нет данных для вывода';
        else  return $res;
    }
    
    public function execute($query,$pl_holders_array) {
        $stmt = $this->_pdo->prepare($query);
        $res = $stmt->execute($pl_holders_array);
        if (!$res) {
            echo '<b>нет данных для ввода</b>';
            exit;
        }
        else return $res;
    }
    public function query($query) {
        return $this->_pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
