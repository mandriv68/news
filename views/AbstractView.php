<?php

class AbstractView {
    
    protected function getHeader() {
        echo <<<HTML
        <!DOCTYPE HTML>
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
        <title>новостная лента</title>
        <script src="/../js/calendar_ru.js" type="text/javascript"></script>
        <link href="/../style/style.css" rel="stylesheet" type="text/css" />
        </head>
        <body>
            <div id="header">
                <div id="logo"></div>
                <div id="vasya"></div>
            </div>
            <div id="wrapper">
HTML;
    }
    
    protected function getMenu() {}
    
    
    protected function getLeftBarAdm() {
        echo <<<HTML_ENTITIES
        <div id="leftbar">
            <div style="text-align:center; font-weight:700; color:#ff8300;">
                АДМИНКА<br>ПУПКИНА
            </div>
            <ul>
                <li><a href="/admin/main/show/news">Новости</a></li>
                <li><a href="/admin/main/show/category">Категории</a></li>
                <li><a href="/admin/main/show/users">Пользователи</a></li>
            </ul>
        </div>
HTML_ENTITIES;
    }
    
    protected function getSearch() {}
    
    protected function getContent() {}
    
    protected function getFuter() {
        echo <<<HTML
            </div>
            <div id="footer">
                собственность ВП, копирование запрещено!!!
            </div>
        </body>
        </html>
HTML;
    }
    
    protected function getBody() {}
    
    protected function getFormNews($datetime,$categories,$news = NULL) {
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
            $selected = ($news->cat==$category->title) ? 'selected="selected" ' : '';
            echo "<option ".$selected."value=".$category->id.">"
                    .$category->title."</option>";
        }  
        echo <<<HTML_ENTITIES
        <select/>
        <input name="id" type="hidden" value={$news->id}>
        <p>
            <input type="submit" value="Сохранить"/>
        </p>
    </form>
HTML_ENTITIES;
    }
    
    protected function getFormCategory($datetime,$categories,$category = NULL) 
    {
        echo <<<HTML_ENTITIES
    <form action="" method="POST">
        <p>Название категории<br/>
           <input name="title" type="text" style="width:420px" value="{$category->title}"/> 
        </p>
        <p>Описание категории<br/>
           <textarea name="description" cols="50" rows="4">{$category->description}</textarea>
        </p>
           
        <input name="text" type="hidden" value="hidden"/>
        <input name="author" type="hidden" value="hidden"/>
        <input name="datetime" type="hidden" value="hidden"/>
        <input name="id" type="hidden" value={$category->id}>
        
        <p>
            <input type="submit" value="Сохранить"/>
        </p>
    </form>
HTML_ENTITIES;
    }
}
