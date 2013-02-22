<?php
class App_controller{
 
    function __construct(){
        
    }
 
    function home(){
        echo Views::instance()->render('protos.html');
    }

    function signup(){
        switch(F3::get('VERB')){
            case 'GET':
                echo Views::instance()->render('signup.html');
            break;
            case 'POST':
                $check=array('email'=>'required','hid'=>'required','password'=>'required');
                $error=Datas::instance()->check(F3::get('POST'),$check);
                if($error){
                    F3::set('errorMsg',$error);
                    echo Views::instance()->render('signup.html');
                    return;
                }
                /*if($user=Admin::instance()->login(F3::get('POST.userName'),F3::get('POST.pw'))){
                    F3::set('SESSION.userId',$user->id);
                    F3::set('SESSION.firstname',$user->firstname);
                    F3::set('SESSION.lastname',$user->lastname);
                    F3::reroute('/admin/dashboard');
                    return;
                }*/
                App::instance()->signup();
                F3::reroute('/admin');
            break;
        }
    }

    function signin(){
        echo Views::instance()->render('signin.html');
    }
 
    function doc(){
        echo Views::instance()->render('userref.html');
    }

    function organ(){
        echo Views::instance()->render('single.html');
    }
    function __destruct(){

    }

}
?>