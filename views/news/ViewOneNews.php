<?php

class ViewOneNews extends AbstractView{
        private $_item = [];
        
        public function __construct($item) {
            $this->_item = $item;
        }

        public function getContent() {
            echo '<div id="art_desc"> <h3>'.$this->_item->title.'</h3>';
            echo '<p class="param">'.$this->_item->datetime.':: Автор:'.$this->_item->author.'<br>=> категория: '.$this->_item->cat;
            echo "<div>".$this->_item->text.
                "<a href='/user/allnews' class='oranged' title='на главную'>назад</a></div></div>";
        }
        
        public function getBody() {
            $this->getHeader();
            $this->getContent();
            $this->getFuter();
        }
    
    }


    
    