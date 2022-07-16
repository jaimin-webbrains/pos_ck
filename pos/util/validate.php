<?php

class Validate {

    public static function valName($value) {
        return preg_match("/^[a-zA-Z ]*$/", $value);
    }
    
    public static function valEmail($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    
    public static function valURL($value) {
        return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$value);
    }

}

?>