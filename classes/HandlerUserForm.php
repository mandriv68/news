<?php

class HandlerUserForm {
    
    private $_user = [];
    private $_login;
    private $_salt;
    private $_iteration;
    private $_pass;
    private $_role;
    
    public function __construct($user) {
        $this->_user = $user;
        
    }
    
    private function getSalt() 
    {
        $this->_salt = (empty($this->_user['salt'])) ? str_replace('=', '', base64_encode(md5(microtime().'1FD37EAA5ED9425683326EA68DCD0E59'))) : $this->_user['salt'];
        return $this->_salt;
    }
    
    private function getIteration() 
    {
        $this->_iteration = (empty($this->_user['iteration'])) ? 99 : $this->_user['iteration'];
        return $this->_iteration;
    }
    
    private function getPass() 
    {
        $pass ='';
        for ($i = 0; $i < $this->_iteration; $i++) {
            $pass = sha1($this->_salt.  $this->_pass);
        }
        return $pass;
    }
        
    public function
            getPlaceholdersArr() 
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
