<?php

class ViewAdmEdit extends AbstractView {
    private $_categories = [];
    private $_item = [];
    
    public function __construct($categories,$item) {
        $this->_categories = $categories;
        $this->_item = $item; 
    }
    
    protected function getMenu() {
        echo <<<HTML_ENTITIES
        <div id="admin_menu"> 
                <div style="display:inline-block; font-size:1.4em; margin-top:10px"><strong>АДмиНКа Василевса П.</strong></div>
                <div id="button" style="float:right; display:inline-block;">
                    <a href="/admin/addnews">добавить новость</a>
                </div>
                <div id="button" style="float:right; display:inline-block; margin-right:20px;">
                    <a href="/admin/main">назад на главную</a>
                </div>        
        </div>
HTML_ENTITIES;
    }
    
    protected function getContent() {
        $datetime = date("Y-m-d", time());
        if (isset($_SESSION['msgs']))
            echo '<p>'.$_SESSION['msgs'].'</p>';
        $this->getForm($datetime, $this->_categories, $this->_item);
    }
    
    public function getBody() {
        $this->getHeader();
        $this->getMenu();
        $this->getContent();
        $this->getFuter();
    }
}
