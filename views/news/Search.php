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
                        <select class="slct" name="category">
                            <option selected value="">все новости</option>
HTML_ENTITIES;
                        foreach ($this->_categories as $category) {
                            $selected = ($news->cat==$category->title) ? 'selected="selected" ' : '';
                            echo "<option value='".$category->id."'>".$category->title."</option>";
                        }  
                        echo <<<HTML_ENTITIES
                        <select/>
                        <span style="display:inline-block;margin-left:20px;float:left;">
                            <b class="slct">с даты</b>
                            <input class="slct" style="width:35px;"
                                                name="from_date_day" 
                                                type="number"
                                                placeholder="ДД"
                                                min="1" max="31"/>
                            <input class="slct" style="width:35px;"
                                                name="from_date_month" 
                                                type="number"
                                                placeholder="ММ"
                                                min="1" max="12"/>
                            <input class="slct" style="width:45px;"
                                                name="from_date_year" 
                                                type="number"
                                                placeholder="ГГГГ"
                                                min="2015" max="2016"/>
                        
                        </span>
                        <span style="display:inline-block;margin-left:20px;float:left;">
                            <b class="slct">по дату</b>
                            <input class="slct" style="width:35px;"
                                                name="by_date_day" 
                                                type="number"
                                                placeholder="ДД"
                                                min="1" max="31"/>
                            <input class="slct" style="width:35px;"
                                                name="by_date_month" 
                                                type="number"
                                                placeholder="ММ"
                                                min="1" max="12"/>
                            <input class="slct" style="width:45px;"
                                                name="by_date_year" 
                                                type="number"
                                                placeholder="ГГГГ"
                                                min="2015" max="2016"/>
                        
                        </span>
                        <input class="sbmt" type="submit" value="OK">
                        <input class="sbmt" type="reset" value="Очистить">
                    </p>
                </form>
            </div>
HTML_ENTITIES;
    }
}
