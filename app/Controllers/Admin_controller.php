<?php
class Admin_controller{
 
    function __construct(){
        
    }
 
    function dashboard(){
        //F3::set('organ',Organ::instance()->getOrgans());
        echo Views::instance()->render('protos.html');
    }
 
    function __destruct(){

    }

}
?>