<?php
class App_controller{
 
    function __construct(){
        
    }
 
    function home(){
        echo Views::instance()->render('protos.html');
    }

    function sendMail(){
        F3::set('from','<fofoy@free.fr>');
        F3::set('to',F3::get('SESSION.email'));
        F3::set('subject','It\'s working');
        ini_set('sendmail_from',F3::get('from'));
        mail(
            F3::get('to'),
            F3::get('subject'),
            Views::instance()->render('email.html','text/html')
        );
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
                        echo Views::instance()->render('account.html');
                        return;
                    }
                }
            break;
        }
    }
 
    function doc(){
        echo Views::instance()->render('userref.html');
    }

    function concept(){
        echo Views::instance()->render('concept.html');
    }

    function contact(){
        echo Views::instance()->render('contact.html');
    }

    function account(){
        echo Views::instance()->render('account.html');
    }

    function basket_test(){
        echo Views::instance()->render('basket_test.html');
    }

    function purchased_test(){
        echo Views::instance()->render('purchased.html');
    }

    function organ(){
        $id=F3::get('PARAMS.id');
        $organ=App::instance()->getOrgan($id);
        if(!$organ){
            F3::error('404');
            return;
        }
        $characteristics=App::instance()->getCharacteristics($id);

        $ajax['model']=$organ->model;
        echo json_encode($ajax);
        F3::set('organ',$organ);
        F3::set('characteristics',$characteristics);
        echo Views::instance()->render('single.html');
    }

    function __destruct(){

    }

}
?>