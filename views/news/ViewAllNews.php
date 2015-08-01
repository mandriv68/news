<?php
    class ViewAllNews extends AbstractView{
        private $_search_array = [];
        private $_items = [];
        
        public function __construct($search_array,$items) {
            $this->_items = $items;
            $this->_search_array = $search_array;
        }

        public function getContent() {
            $srch = new Search($this->_search_array);
            $srch->search();
            foreach ($this->_items as $news) {
                $href = '/user/onenews/id/'.$news->id;
                echo '<div id="art_desc"> <h3>'.$news->title.'</h3>';
                echo "<div>$news->description".
                    "<a href='$href' class='oranged'>  ...читать полностью</a></div></div>";
            }
        }
                
        public function getBody() {
            $this->getHeader();
            $this->getContent();
            $this->getFuter();
        }
    
    }
    