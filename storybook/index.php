<?php
session_start(); // for authentication
/****************lisää ylläoleva istunnon aloitus*************/

require './Route.php'; // routing class
require './database/db.php'; // database connection

require './controllers/storyController.php';
$storyController = new StoryController();

require './controllers/userController.php';
$userController = new UserController();

require_once ('./database/models/User.php');
$user = new User();


//every route gets its own controller or view
Route::add('/',function() {
    global $storyController;
    $storyController->index();    
},'get');

Route::add('/story/(.*)',function($id) use ($storyController){
    $storyController->readStory($id);
},'get');

Route::add('/register/',function() {
    require './views/registerform.view.php';
},'get');

Route::add('/register/',function() use ($userController,$user) {
    $userController->register();
},'post');


/********* LISÄÄ SEURAAVAT *****************
$user luodaan, kun luodaan uusi userController-olio, välitetään $userControllerin sisällä, ja koska se on protected, tarvitaan metodi getUser() sen hakemiseen */

Route::add('/login/',function() {
    require './views/loginform.view.php';
},'get');


Route::add('/login/',function() use ($userController) {
    $userController->login($userController->getUser());
},'post');


Route::add('/logout/',function() use ($userController) {
    $userController->logout($userController->getUser());
},'get');

/********************************************/

Route::add('/admin/', function() use ($userController,$storyController) {
    if($userController->getUser()->sessionLogin())
    {
        $storyController->admin($userController->getUser());
    }
    else require './views/loginform.view.php';
},'get');

Route::add('/addstory/', function() use ($userController,$storyController) {
    if($userController->getUser()->sessionLogin()) { 
        $storyController->getAddStory($userController->getUser());
    }
    else require './views/loginform.view.php';
},'get');


Route::add('/addstory/', function() use ($userController,$storyController) {
    if($userController->getUser()->sessionLogin()) $storyController->postAddStory($userController->getUser());
    else require './views/loginform.view.php';    
},'post');

Route::add('/editstory/(.*)', function($id) use ($userController,$storyController) {
    if($userController->getUser()->sessionLogin())  $storyController->getEditStory($id,$userController->getUser());
    else require './views/loginform.view.php';
},'get');

Route::add('/editstory/(.*)', function($id) use ($userController,$storyController) {
    if($userController->getUser()->sessionLogin()) $storyController->postEditStory($userController->getUser());
    else require './views/loginform.view.php';    
},'post');

Route::add('/deletestory/(.*)', function($id) use ($userController,$storyController) {
    if($userController->getUser()->sessionLogin()) $storyController->deleteStory($id,$userController->getUser());
    else require './views/loginform.view.php';
},'get');

//start...
Route::run('/');

?>