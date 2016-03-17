<?php

session_start();
require_once("gameController.php");
require_once("HTMLView.php");
require_once("gameModel.php");
require_once("gameView.php");
require_once("upload.php");


$output = new  HTMLView();
$controller = new gameController();
//$registerController = new RegisterController();
$model = new gameModel();
$view = new gameView($model);
//$registerview = new RegisterView();

// Kollar ifall användaren tryck på "Registrera ny användare".
if($view->didUsersUpload() === true){
	$htmlBody= $controller->doControll();
}

elseif($view->submitMail()==true){
    $htmlBody=$controller->mailControll();
}
else{
}   
 	$htmlBody = $controller->doRegisterControll();



$output->echoHTML($htmlBody);






