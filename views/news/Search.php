<?php

class Search {
    
    private $_categories;
    private $_authors;
    
    public function __construct($search) {
        $this->_categories = $search['categories'];
        $this->_authors = $search['authors'];
    }
    
    public function search() {
        $msgs = (isset($_SESSION['msgs'])) ? '   ::   '.$_SESSION['msgs'] : '';
        echo <<<HTML_ENTITIES
            <div style="margin-top; 10px; padding: 10px;">
            <p style="color: #FF8300; text-shadow: 1px 1px 2px  rgba(0,0,0,0.8);">сортировка$msgs</p>
                <form action="/user/allnews" method="POST">
                    <p>    
                        <select class="slct" name="category">
                            <option selected value="">все новости</option>
HTML_ENTITIES;
                        foreach ($this->_categories as $category) {
                            $selected = ($news->cat==$category->title) ? 'selected="selected" ' : '';
                            echo "<option value='".$category->id."'>".$category->title."</option>";
                        }  
                        echo <<<HTML_ENTITIES
                        <select/>
                        <span class="slct">
                            <input class="slct" type="text" name="from_date" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"  placeholder="с даты">                       
                            <input class="slct" type="text" name="by_date" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"  placeholder="по дату">
                        </span>
                        <span class="slct">
                            <input class="slct" type="search" name="author" placeholder="имя автора или часть имени">
                        </span>
                        <input class="sbmt" type="submit" value="OK">
                        <input class="sbmt" type="reset" value="Очистить">
                    </p>
                </form>
            </div>
HTML_ENTITIES;
    }
}
