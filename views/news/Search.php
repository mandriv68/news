<?php

class Search {
    
    private $_categories;
    private $_authors;
//    private $_datetime;
    
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
                        <select name="category">
                            <option selected value="">все новости</option>
HTML_ENTITIES;
                        foreach ($this->_categories as $category) {
                            $selected = ($news->cat==$category->title) ? 'selected="selected" ' : '';
                            echo "<option value='".$category->id."'>".$category->title."</option>";
                        }  
                        echo <<<HTML_ENTITIES
                        <select/>
                        <input stile="display:inline-block;float:left;margin-left:20px;" type="submit" value="OK">
                                        <input stile="display:inline-block;float:left;margin-left:20px;" type="reset" value="Очистить">
                    </p>
                </form>
            </div>
HTML_ENTITIES;
    }
}
