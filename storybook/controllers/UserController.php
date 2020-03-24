<?php

require './database/models/User.php'; // user management for authentication

class UserController
{
    protected $user;
    
    public function __construct()
    {
        $this->user = new User();
    }
    


    public function register()
    {
        require "./helpers/helper.php";

        if(isset($_POST["account_name"],$_POST["password1"],$_POST["password2"],$_POST["last_name"],$_POST["first_name"]) && $_POST["password1"]==$_POST["password2"]){
        $password=sanitize($_POST["password1"]);
        $account_name=$_POST["account_name"];
        $last_name= sanitize($_POST["last_name"]);
        $first_name= sanitize($_POST["first_name"]);

        $password = password_hash($password, PASSWORD_DEFAULT);

        $newAccount=$this->user->addAccount($last_name,$first_name, $account_name,$password);
        
        require './views/registered.view.php';
        } else {
            $message ="Tarkista salasanat";
            require './views/registerform.view.php';
        }
    }
    
/*******************LISÄÄ SEURAAVAT ***************/
    
    public function getUser() 
    {
        return $this->user;
    }
    
    public function login($user)
    {
        require './helpers/helper.php';
    
        if(isset($_POST["account_name"], $_POST["password"])) {
        $name=sanitize($_POST["account_name"]);
        $password=sanitize($_POST["password"]);
        }

        if($user->login($name,$password)) {
            require './views/admin.view.php';
        }
        else {
            $message ="Tarkista käyttäjätunnus ja salasana";
            require './views/loginform.view.php';
        }
    }
    
    public function logout($user)
    {
        $user->logout();
        $stories = Story::get_last_five_stories_and_name();
        require './views/index.view.php';
    }
}    
?>