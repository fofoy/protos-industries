<?php
class Organ extends Prefab{

    function __construct(){
        F3::set('dB',new DB\SQL('mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),F3::get('db_user'),F3::get('db_pw')));
    }

    function getAllOrgans(){
    	$organ=new DB\SQL\Mapper(F3::get('dB'),'organ');
    	return $organ->find();
    }

    function __destruct(){
    	
    }

}
?>