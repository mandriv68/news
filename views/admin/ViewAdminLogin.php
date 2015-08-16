<?php
class ViewAdminLogin extends AbstractView
{
    private $msgs = null;
    
    public function __construct($msgs) {
        $this->msgs = $msgs;
    }

    public function logInForm() {
        echo 
    '<div id="loginform">
        <h1>Добро пожаловать в АДМИНКУ ПУПКИНА</h1>';
        if ($this->msgs) {   
        echo    '<div id="errorLogin">
                    <img src="/../../images/stop.png"/>'.$this->msgs.
                '</div>';
        }
        echo <<<HTML_ENTITIES
        <!-- Login form -->
        <form method="post" action="" name="login_form">
            <fieldset>
                <legend>Авторизация</legend>
                <div>
                    <label for="input_username">Пользователь:</label>
                    <input type="text" name="login" value="" size="24" class="textfield"/>
                </div>
                <div>
                    <label for="input_password">Пароль:</label>
                    <input type="text" name="pass" value="" size="24" class="textfield" />
                </div>    
                <!-- input type="hidden" name="server" value="1" / -->
            </fieldset>
            <fieldset id="fieldsetFooter">
                <input value="Вход" type="submit" id="inputGo" />
            </fieldset>
        </form>
    </div>
HTML_ENTITIES;
    }
    
    public function getBody() {
        $this->getHeader();
        $this->logInForm();
        $this->getFuter();
    }
}


