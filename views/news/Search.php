<?php

class Search {
    
    private $_categories;
    private $_authors;
    
    public function __construct($search) {
        $this->_categories = $search['categories'];
        $this->_authors = $search['authors'];
    }
    
    public function search() {
        echo <<<HTML_ENTITIES
            <div style="margin-top; 10px; padding: 10px;">
            <p>сортировка</p>
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
                        <input class="sbmt" type="submit" value="OK">
                        <input class="sbmt" type="reset" value="Очистить">
                    </p>
                </form>
            </div>
HTML_ENTITIES;
    }
}
