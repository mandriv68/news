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
    
    protected function getLeftBarAdm() {
        parent::getLeftBarAdm();
        $this->_style = 'margin-left:200px;border-left:2px solid rgba(255, 131, 0,0.2)';
    }
    
    protected function getContent() {
        $datetime = time();
        $method_name = 'getForm'.ucfirst($this->_model);
        echo <<<HTML_ENTITIES
        <div id="content" style="$this->_style">
            <div style="height:31px;margin-top:10px;">
                <div class="msgs" style="width:60%;">:: 
HTML_ENTITIES;
            if (!empty($_SESSION['msgs'])){
                echo $_SESSION['msgs'];
            }
            echo <<<HTML_ENTITIES
              ::</div>
                <div id="button">
                    <a href="/admin/add/show/$this->_model">добавить ещё</a>
                </div>
                <div id="button" style="margin-left:10px;">
                    <a href="/admin/main/show/$this->_model">назад</a>
                </div> 

            </div>
HTML_ENTITIES;
        $this->{$method_name}($datetime, $this->_categories, $this->_item);
        echo '</div>';
        unset($_SESSION['msgs']);
    }
    
    public function getBody() {
        $this->getHeader();
        $this->getLeftBarAdm();
        $this->getContent();
        $this->getFuter();
    }
}
