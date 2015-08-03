<?php
class VarDump {
    public static function dump($val) {
        echo '<pre>';
        var_dump($val);
        echo '</pre>';
    }
    public static function prnt($val) {
        echo '<pre>';
        print_r($val);
        echo '</pre>';
    }
}
