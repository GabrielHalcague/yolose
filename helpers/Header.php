<?php

class Header{

    public static function redirect($location){
        header("location: $location");
        exit();
    }

    public static function debugExit($var)
    {
        var_dump($var);
        echo "<br>";
        exit();
    }

    public static function debug($var)
    {
        var_dump($var);
        echo "<br>";
    }

}