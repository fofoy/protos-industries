<?php
class App extends Prefab{

    function __construct(){
        F3::set('dB',new DB\SQL('mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),F3::get('db_user'),F3::get('db_pw')));
    }

    function signup(){
    	$user=new DB\SQL\Mapper(F3::get('dB'),'user');
    	$user->email=$_POST['email'];
    	$user->hid=$_POST['hid'];
    	$user->password=md5($_POST['password']);
    	$usertest=new DB\SQL\Mapper(F3::get('dB'),'user');
    	$usertest->load(array('email=?',$user->email));
    	if($usertest->email){
    		$errorMsg = 'Votre e-mail est déjà associée à un compte';
    		return $errorMsg;
    	}
    	$user->save();
    }

    function login($id,$pw){
        $user=new DB\SQL\Mapper(F3::get('dB'),'user');
        return $user->load(array('email=? and password=?',$id,md5($pw)));
    }

    function getOrgan($id){
        $organ=new DB\SQL\Mapper(F3::get('dB'),'organ');
        return $organ->load(array('id=?',$id));
    }

    function getCharacteristics($idOrgan){
        $characteristics=new DB\SQL\Mapper(F3::get('dB'),'characteristics');
        return $characteristics->find(array('organ_id=?',$idOrgan));
    }

    function __destruct(){
    	
    }

}
?>