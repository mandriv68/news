<?php

class ViewAdmMain extends AbstractView{
    
    private $_items = [];
    private $_style = '';
    
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
    
    protected function getLeftBar() {
        echo <<<HTML_ENTITIES
        <div id="leftbar">
            <ul>
                <li>leftbar1</li>
                <li>leftbar2</li>
                <li>leftbar3</li>
                <li>leftbar4</li>
            </ul>
        </div>
HTML_ENTITIES;
        $this->_style = 'margin-left:200px;border-left:2px solid rgba(255, 131, 0,0.2)';
    }
    
    protected function getContent() {
        echo <<<HTML_ENTITIES
        <div id="content" style="$this->_style">
            <div style="height:31px;margin-top:10px;">
                <div style="text-align:center;color:#FF8300;font-weight:700;height: 28px;width:70%;float:left;display:inline-block;">:: 
HTML_ENTITIES;
            if (!empty($_SESSION['res'])){
                echo $_SESSION['res'];
            }
            echo <<<HTML_ENTITIES
              ::</div>
                <div id="button">
                    <a href="/admin/addnews">добавить новость</a>
                </div>
            </div>
HTML_ENTITIES;
            foreach ($this->_items as $news) {
                $href_edit = '/admin/editnews/id/'.$news->id;
                $href_del = '/admin/delitenews/id/'.$news->id;
                $sub = substr($news->description,0,300);
                $desc =  explode(' ',$sub);
    //            $i = count($desc)-1;
                unset($desc[count($desc)-1]);
                $description = implode(' ',$desc);
                echo <<<HTML_ENTITIES
            <div style="border:1px solid rgba(255, 131, 0,0.2);padding:0px 10px; margin:10px auto;">
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
    echo '</div>';    
    }
    
    public function getBody() {
        $this->getHeader();
        $this->getLeftBar();
        $this->getContent();
        $this->getFuter();
    }
}
