<?php

class ViewAdmMain extends AbstractView{
    
    private $_items = [];
    private $_style = '';
    private $_method = '';


    public function __construct($items,$method) {
        $this->_items = $items;
        $this->_method = $method;
    }
    
    protected function getLeftBarAdm() {
        parent::getLeftBarAdm();
        $this->_style = 'margin-left:200px;border-left:2px solid rgba(255, 131, 0,0.2)';
    }
    
    protected function getContent() {
        $button_add = '';
        $method = '';
        switch ($this->_method) {
            case 'category': $button_add = 'категорию';    $method = 'category'; break;
            case 'user' :    $button_add = 'пользователя'; $method = 'user'; break;
            default:         $button_add = 'новость';      $method = 'news'; break;
        }
        echo <<<HTML_ENTITIES
        <div id="content" style="$this->_style">
            <div style="height:31px;margin-top:10px;">
                <div class="msgs" style="width:70%;">:: 
HTML_ENTITIES;
            if (!empty($_SESSION['res'])){
                echo $_SESSION['res'];
            }
            echo <<<HTML_ENTITIES
              ::</div>
                <div id="button">
                    <a href="/admin/add/show/$method">добавить $button_add</a>
                </div>
            </div>
HTML_ENTITIES;
            $method_name = 'All'.ucfirst($method);
            $this->{$method_name}();
    echo '</div>';    
    }
    
    protected function AllNews() {
        foreach ($this->_items as $news) {
                $href_edit = '/admin/edit/show/'.$this->_method.'/id/'.$news->id;
                $href_del = '/admin/delete/show/'.$this->_method.'/id/'.$news->id;
                $sub = substr($news->description,0,300);
                $desc =  explode(' ',$sub);
    //            $i = count($desc)-1;
                unset($desc[count($desc)-1]);
                $description = implode(' ',$desc);
                echo <<<HTML_ENTITIES
            <div class="item_box">
                <h3 style="margin-bottom:-10px;">$news->title</h3>
                <p style="margin-bottom:-10px;">$description<span stile="color:#FF8300;font-weight:bold;">&nbsp&nbsp...</span></p>
                <p style="text-align:right;color:#FF8300;line-height:80%;">
                    <a href="$href_edit" class="oranged">редактировать</a>
                    <span>&nbsp&nbsp::&nbsp&nbsp</span>
                    <a href="$href_del" class="oranged">удалить</a>
                </p>
            </div>
HTML_ENTITIES;
            }
    }

    protected function AllCategory() {
        foreach ($this->_items as $category) {
                $href_edit = '/admin/edit/show/'.$this->_method.'/id/'.$category->id;
                $href_del = '/admin/delete/show/'.$this->_method.'/id/'.$category->id;
                echo <<<HTML_ENTITIES
            <div class="item_box">
                <h3 style="margin-bottom:-10px;">$category->title</h3>
                <p style="margin-bottom:-10px;">$category->description<span stile="color:#FF8300;font-weight:bold;">&nbsp&nbsp...</span></p>
                <p style="text-align:right;color:#FF8300;line-height:80%;">
                    <a href="$href_edit" class="oranged">редактировать</a>
                    <span>&nbsp&nbsp::&nbsp&nbsp</span>
                    <a href="$href_del" class="oranged">удалить</a>
                </p>
            </div>
HTML_ENTITIES;
            }
    }

    public function getBody() {
        $this->getHeader();
        $this->getLeftBarAdm();
        $this->getContent();
        $this->getFuter();
    }
}
