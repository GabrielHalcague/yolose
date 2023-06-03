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
    public static function finalizarSesion(){
     session_unset();
     session_destroy();
    }
    public static function menuSegunElRol(array $data): array  {
        $data['logged'] = Session::get('logged')?? false;
        $data['editor'] = Session::get('editor')?? false;
        $data['administrador'] = Session::get('administrador')?? false;
        $data['nombre']= Session::get('nombre');
        $data['ranking']="123";// esto tendria que modificarse cuando se ingrese creo
        return $data;
    }

}