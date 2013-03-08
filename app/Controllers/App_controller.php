<?php
class App_controller{

    public $basket;

    function __construct(){
        $this->basket=new \Basket;
        $count=$this->basket->count();
        F3::set('count',$count);
    }

    /*function beforeroute(){
        if(!is_callable(array($this, F3::get('PARAMS.action')))){
            F3::reroute('404');
        }
    }*/
 
    function home(){
        echo Views::instance()->render('aboutus.html');
    }

    function logout(){
        session_destroy();
        F3::reroute('/');
    }

    function addToBasket(){
        var_dump($_POST);
        $id=F3::get('PARAMS.id');
        $organ=App::instance()->getOrgan($id);
        if(!$organ){
            F3::error('404');
            return;
        }
        $this->basket->set('item',$organ->name);
        $this->basket->set('description',$organ->description);
        $this->basket->set('quantity',1);
        $this->basket->set('price',$organ->price);
        $this->basket->save();
        F3::reroute('/basket');
    }

    function show(){
        echo Views::instance()->render('basket_test.html');
    }

    function sendMail(){
        F3::set('from','<no-reply@mysite.com>');
        F3::set('to','<maxime.debavelaere@gmail.com>');
        F3::set('subject','Welcome');
        ini_set('sendmail_from',F3::get('from'));
        mail(
            F3::get('to'),
            F3::get('subject'),
            Views::instance()->render('email.html')
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
                    F3::reroute('/signup');
                } else {
                    if($user=App::instance()->login(F3::get('POST.email'),F3::get('POST.password'))){
                        F3::set('SESSION.id',$user->id);
                        F3::set('SESSION.hid',$user->hid);
                        F3::set('SESSION.email',$user->email);
                        F3::reroute('/account');
                        return;
                    }
                    F3::set('errorMsg',array('userName'=>true,'pw'=>true));
                    echo Views::instance()->render('signin.html');
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

    function products(){
        $organs=App::instance()->getAllOrgans();
        $characteristics=App::instance()->getAllCharacteristics();
        F3::set('organs',$organs);
        F3::set('characteristics',$characteristics);
        echo Views::instance()->render('products.html');
    }

    function account(){
        $informations=App::instance()->getPersonalInformations(F3::get('SESSION.hid'));
        F3::set('informations',$informations);
        F3::set('SESSION.firstname',$informations->firstname);
        echo Views::instance()->render('account.html');
    }

    function basket_test(){
        if(F3::get('VERB')=='POST'){
            $this->basket->drop();
            echo Views::instance()->render('purchased.html');
            return;
        }
        echo Views::instance()->render('basket_test.html');
    }

    function purchased_test(){
        echo Views::instance()->render('purchased.html');
    }

    function conditions(){
        echo Views::instance()->render('conditions.html');
    }

    function organ(){
        $id=F3::get('PARAMS.id');
        $organ=App::instance()->getOrgan($id);
        if(!$organ){
            F3::error('404');
            return;
        }
        $characteristics=App::instance()->getCharacteristics($id);
        if(F3::get('AJAX')){
            $ajax['organ']['model']=$organ->model;
            echo json_encode($ajax);
            return;
        }
        F3::set('organ',$organ);
        F3::set('characteristics',$characteristics);
        echo Views::instance()->render('single.html');
    }

    function __destruct(){

    }

}
?>