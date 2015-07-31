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
            foreach ($this->_items as $item) {
                $href = '/user/onenews/id/'.$item->art_id;
                echo '<div id="art_desc"> <h3>'.$item->art_title.'</h3>';
                echo "<div>$item->art_description".
                    "<a href='$href' class='oranged'>  ...читать полностью</a></div></div>";
            }
        }
                
        public function getBody() {
            $this->getHeader();
            $this->getContent();
            $this->getFuter();
        }
    
    }
    