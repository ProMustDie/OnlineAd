<?php
include('app.php');
include_once 'Classified.php';

$classified = new Classified;

$requests = $_GET['request'];

if($_SESSION['auth_user']['user_type']=="Admin"){

    if($requests=="deleteAd"){
        $AdID = $_POST['AdID'];	
        $classified->deleteAd($AdID);
        header('Location: ../Main.php');
    }
    
}
?>