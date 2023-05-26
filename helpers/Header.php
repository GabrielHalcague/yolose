<?php

class Header{

    public static function redirect($location){
        header("location: $location");
        exit();
    }

}