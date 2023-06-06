<?php

class Session {

    public static function initializeSession(){
        session_start();
    }

    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        return $_SESSION[$key] ?? '' ;
    }

    public static function getDataSession(){
        return $_SESSION;
    }

    public static function deleteValue($value){
        if(isset($_SESSION[$value])){
            unset($_SESSION[$value]);
        }
    }

    public static function finalizarSesion(){
     session_unset();
     session_destroy();
    }

    public static function isLogged()
    {
        return isset($_SESSION['logged']);
    }


}