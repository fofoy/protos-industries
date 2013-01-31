<?php
class App_controller{
 
    function __construct(){

    }
 
    function home(){
        echo Views::instance()->render('protos.html');
    }
 
 
    function doc(){
        echo Views::instance()->render('userref.html');
    }
 
    function __destruct(){

    } 

}
?>