<?php

class ViewAdmMain extends AbstractView{
    
    private $_items = [];
    private $_style = '';
    private $_method = '';
    private $_msgs = '';


    public function __construct($items=NULL, $method=NULL, $msgs=NULL) {
        $this->_items = $items;
        $this->_method = $method;
        $this->_msgs = $msgs;
    }
    
    protected function getLeftBarAdm() {
        parent::getLeftBarAdm();
        $this->_style = 'margin-left:200px;border-left:2px solid rgba(255, 131, 0,0.2)';
    }
    
    protected function getContent() {
        $button_add = '';
        switch ($this->_method) {
            case 'category': $button_add = 'категорию'; break;
            case 'user' :    $button_add = 'пользователя'; break;
            default:         $button_add = 'новость'; break;
        }
        echo <<<HTML_ENTITIES
        <div id="content" style="$this->_style">
            <div style="height:31px;margin-top:10px;">
                <div class="msgs" style="width:65%;">:: 
HTML_ENTITIES;
            if (!empty($_SESSION['res'])){
                echo $_SESSION['res'];
            }
            echo <<<HTML_ENTITIES
              ::</div>
                <div id="button">
                    <a href="/admin/save/show/$this->_method/opt/add">добавить $button_add</a>
                </div>
            </div>
HTML_ENTITIES;
            if ($this->_items) {
                $method_name = 'All'.ucfirst($this->_method);
                $this->{$method_name}();
            }
    echo '</div>'.
         '<div style="height:1px;clear:both;"></div>' ;    
    }
    
    private function AllNews() {
        foreach ($this->_items as $news) {
                $href_edit = '/admin/save/show/'.$this->_method.'/opt/edit/id/'.$news->id;
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

    private function AllCategory() {
        foreach ($this->_items as $category) {
                $href_edit = '/admin/save/show/'.$this->_method.'/opt/edit/id/'.$category->id;
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
    
    private function AllUser() {
        foreach ($this->_items as $user) {
                $href_edit = '/admin/save/show/'.$this->_method.'/opt/edit/id/'.$user->login;
                $href_del = '/admin/delete/show/'.$this->_method.'/id/'.$user->login;
                echo <<<HTML_ENTITIES
            <div class="item_box">
                <p>логин &nbsp&nbsp&nbsp 
                    <h3 style="margin-bottom:-10px;">$user->login</h3>
                </p>
                <p style="margin-bottom:-10px;font-weight:700;font-size:1.2em;"><span stile="color:#FF8300;font-weight:300;font-size:0.8em !important;">привилегии&nbsp&nbsp</span>$user->role</p>
                <p style="text-align:right;color:#FF8300;line-height:80%;">
                    <a href="$href_edit" class="oranged">редактировать</a>
                    <span>&nbsp&nbsp::&nbsp&nbsp</span>
                    <a href="$href_del" class="oranged">удалить</a>
                </p>
            </div>
HTML_ENTITIES;
        }
    }
    
    public function logInForm() {
        if (!$this->_msgs) return FALSE;
        else {
            echo <<<HTML_ENTITIES
<div style="position:absolute; z-index: 1000; top:150px; left:450px; height:200px; width:350px; padding:20px; background-color: rgba(255,255,255,0.8);">
    <form action="" method="POST">
        <p> $this->_msgs </p>
        <p>логин<br/>
           <input name="login" type="text" style="width:220px" value=""/> 
        </p>
        <p>пароль<br/>
           <input name="pass" type="text" style="width:220px" value=""/>
        </p>
        <p>
            <input type="submit" value="Войти"/>
        </p>
        </form>
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
