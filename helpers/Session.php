<?php

class Session {

    public static function initializeSession(){
        session_start();
    }

    public static function set($key, $value){
        $_SESSION['$key'] = $value;
    }

    public static function get($key){
        return $_SESSION['$key'];
    }

    public static function getDataSession(){
        return $_SESSION;
    }

}