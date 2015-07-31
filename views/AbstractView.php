<?php

class AbstractView {
    
    protected function getHeader() {
        echo <<<HTML
        <!DOCTYPE HTML>
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
        <title>новостная лента</title>
        <link href="/../style/style.css" rel="stylesheet" type="text/css" />
        </head>
        <body>
            <div id="header">
                <div id="logo"></div>
                <div id="vasya"></div>
            </div>
HTML;
    }
    
    protected function getMenu() {}
    
    protected function getSearch() {}
    
    protected function getContent() {}
    
    protected function getFuter() {
        echo <<<HTML
                <div id="footer">
                собственность ВП, копирование запрещено!!!
            </div>
        </body>
        </html>
HTML;
    }
    
    protected function getBody() {}
    
    protected function getForm($datetime,$categories,$news = NULL) {
        echo <<<HTML_ENTITIES
    <form action="" method="POST">
        <p>Название новости<br/>
           <input name="title" type="text" style="width:420px" value="{$news->title}"/> 
        </p>
        <p>Краткое содержание новости<br/>
           <textarea name="description" cols="50" rows="7">{$news->description}</textarea>
        </p>
        <p>Полный текст новости<br/>
           <textarea name="text" cols="50" rows="7">{$news->text}</textarea>
        </p>
        <p>Автор<br/>
           <input name="author" type="text" style="width:420px" value="{$news->author}"/>
           <input name="datetime" type="hidden" value="$datetime"/>
        </p>
        <select name="category">
HTML_ENTITIES;
        foreach ($categories as $category) {
            $selected = ($news->cat==$category->cat_title) ? 'selected="selected" ' : '';
            echo "<option ".$selected."value='".$category->cat_id."'>".$category->cat_title."</option>";
        }  
        echo <<<HTML_ENTITIES
        <select/>
        <p><input name="button" type="submit" value="Сохранить"/></p>
    </form>
HTML_ENTITIES;
    }
}
