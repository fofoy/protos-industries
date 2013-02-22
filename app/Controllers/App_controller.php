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
                if($user=App::instance()->login(F3::get('POST.email'),F3::get('POST.password'))){
                    F3::set('SESSION.id',$user->id);
                    F3::set('SESSION.email',$user->email);
                    F3::reroute('/');
                    return;
                }
                App::instance()->signup();
                F3::reroute('/');
            break;
        }
    }

    function signin(){
        switch(F3::get('VERB')){
            case 'GET':
                echo Views::instance()->render('signin.html');
            break;
            case 'POST':
                if(isset($_POST['email']) && $_POST['account_choice'] == 'no'){
                    F3::set('email',$_POST['email']);
                    echo Views::instance()->render('signup.html');
                } else {
                    if($user=App::instance()->login(F3::get('POST.email'),F3::get('POST.password'))){
                        F3::set('SESSION.id',$user->id);
                        F3::set('SESSION.email',$user->email);
                        echo Views::instance()->render('single.html');
                        return;
                    }
                }
            break;
        }
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