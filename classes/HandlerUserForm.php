<?php

class HandlerUserForm {
    
    private $_user = [];
    
    public function __construct($user) {
        $this->_user = $user;
    }
    
    private function getSalt() 
    {
        $salt = '';
        return $salt = (empty($this->_user['salt'])) ? str_replace('=', '', base64_encode(md5(microtime().'1FD37EAA5ED9425683326EA68DCD0E59'))) : $this->_user['salt'];
    }
    
    private function getIteration() 
    {
        $iteration = 0;
        return $iteration = (empty($this->_user['iteration'])) ? 99 : $this->_user['iteration'];
    }
    
    private function getPass() 
    {
        $pass ='';
        $it = $this->getIteration();
        $salt = $this->getSalt();
        $psw = $this->_user['pass'];
        for ($i = 0; $i < $it; $i++) {
            $pass = sha1($psw.$salt);
        }
        return $pass;
    }
        
    public function getPlaceholdersArr() 
    {
        $place_array = [];
        foreach ($this->_user as $key => $value) {
            switch ($key) {
                case 'login':
                    $place_array[':'.$key] = $value;
                    break;
                case 'salt':
                    $place_array[':'.$key] = $this->getSalt();
                    break;
                case 'iteration':
                    $place_array[':'.$key] = $this->getIteration();
                    break;
                case 'pass':
                    $place_array[':'.$key] = $this->getPass();
                    break;
                case 'role':
                    $place_array[':'.$key] = $value;
                    break;
            }
        }
        return $place_array;
    }
}
