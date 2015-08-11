<?php

class ViewAdmSave extends AbstractView {
    private $_categories = [];
    private $_item = [];
    private $_model = '';


    public function __construct($item,$categories,$model) {
        $this->_item = $item; 
        $this->_categories = $categories;
        $this->_model = $model;
    }
    
    protected function getMenu() {
        echo <<<HTML_ENTITIES
        <div id="admin_menu"> 
                <div style="display:inline-block; font-size:1.4em; margin-top:10px"><strong>АДмиНКа Василевса П.</strong></div>
                <div id="button" style="float:right; display:inline-block; margin-top:5px;">
                    <a href="/admin/add/show/$this->_model">добавить ещё</a>
                </div>
                <div id="button" style="float:right; display:inline-block; margin-right:20px;  margin-top:5px;">
                    <a href="/admin/main/show/$this->_model">назад</a>
                </div>        
        </div>
HTML_ENTITIES;
    }
    
    protected function getContent() {
        $datetime = time();
        $method_name = 'getForm'.ucfirst($this->_model);
        echo '<div id="content">';
        $this->getMenu();
        $this->{$method_name}($datetime, $this->_categories, $this->_item);
        echo '</div>';
    }
    
    public function getBody() {
        $this->getHeader();
//        $this->getMenu();
        $this->getContent();
        $this->getFuter();
    }
}
