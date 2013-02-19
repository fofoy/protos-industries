<?php
class Organ_controller{
 
    function __construct(){
        
    }
 
    function getorgans(){
        F3::set('organ',Organ::instance()->getAllOrgans());
        echo Views::instance()->render('protos.html');
    }
 
    function __destruct(){

    }

}
?>