<?php

class ViewAdmMain extends AbstractView{
    
    private $_items = [];
    
    public function __construct($items) {
        $this->_items = $items;
    }
    
    protected function getMenu() {
        echo <<<HTML_ENTITIES
        <div id="admin_menu"> 
                <div style="display:inline-block; font-size:1.4em; margin-top:10px"><strong>АДмиНКа Василевса П.</strong></div>
                <div id="button" style="float:right; display:inline-block;">
                    <a href="/admin/addnews">добавить новость</a>
                </div>    
        </div>
HTML_ENTITIES;
    }
    
    protected function getContent() {
        if (!empty($_SESSION['res'])){
            echo '<p style="text-align:center;color:#FF8300;font-weight:700;">'.$_SESSION['res'].'</p>';
        }
        foreach ($this->_items as $news) {
            $href_edit = '/admin/editnews/id/'.$news->id;
            $href_del = '/admin/delitenews/id/'.$news->id;
            $sub = substr($news->description,0,300);
            $desc =  explode(' ',$sub);
//            $i = count($desc)-1;
            unset($desc[count($desc)-1]);
            $description = implode(' ',$desc);
            echo <<<HTML_ENTITIES
            <div style="border:1px solid grey;padding:0px 10px; margin:10px auto;">
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
    
    public function getBody() {
        $this->getHeader();
        $this->getMenu();
        $this->getContent();
        $this->getFuter();
    }
}
