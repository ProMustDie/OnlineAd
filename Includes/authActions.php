<?php
include('app.php');
include_once 'Classified.php';

$classified = new Classified;

$requests = $_GET['request'];

$AuthorID = isset($_POST['AdAuthorID'])? $_POST['AdAuthorID'] : NULL;
$AdID = isset($_POST['AdID'])?$AdID = $_POST['AdID']:NULL;
$redirect = empty($_POST['redirect'])?"Main.php": $_POST['redirect'];

if($_SESSION['auth_user']['user_type']=="Admin"){

    if($AdID != NULL){

    if($requests == "RejectRequest" || $requests == "AcceptRequest" ||$requests == "RejectPayment" ||$requests == "ApproveAd" ||$requests == "Expire" ||$requests == "CancelAd"):
        switch($requests){
            case "RejectRequest":
                $status = "Rejected Request";
                break;
            case "AcceptRequest":
                $status = "Pending Payment";
                $price = empty($_POST['Price'])? NULL : $_POST['Price'];
                $classified->setPrice($AdID, $price);
                break;
            case "RejectPayment":
                $status = "Rejected Payment";
                break;
            case "ApproveAd":
                $status = "Approved";
                $classified->setPostTimeNOW($AdID);
                break;
            case "Expire":
                $status = "Expired";
                break;
            case "CancelAd":
                $status = "Cancelled";
                break;
        }
        $classified->changeStatus($AdID, $status);
        header("Location: ../$redirect"); 
    endif;
    }
}


if($_SESSION['auth_user']['user_id'] == $AuthorID && $AuthorID!=NULL && $AdID != NULL){
    
    if($requests== "SubmitPayment" ||$requests == "CancelAd"):
    switch($requests){
        case "SubmitPayment":
            $status = "Checking Payment";
            break;
        case "CancelAd":
            $status = "Cancelled";
            break;
    }
    $classified->changeStatus($AdID, $status);
    header("Location: ../$redirect"); 
    endif;
}
?>