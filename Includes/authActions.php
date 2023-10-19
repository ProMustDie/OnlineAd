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

$AuthorID = isset($_POST['AdAuthorID'])? $_POST['AdAuthorID'] : NULL;
if($_SESSION['auth_user']['user_id'] == $AuthorID || $_SESSION['auth_user']['user_type'] == "Admin"){
    $AdID = $_POST['AdID'];
    if($requests == "RejectRequest" || $requests == "AcceptRequest" ||$requests == "RejectPayment" ||$requests == "ApproveAd" ||$requests == "Expire" ||$requests == "CancelAd"):
    switch($requests){
        case "RejectRequest":
            $status = "Rejected Request";
            break;
        case "AcceptRequest":
            $status = "Pending Payment";
            break;
        case "RejectPayment":
            $status = "Rejected Payment";
            break;
        case "ApproveAd":
            $status = "Approved";
            break;
        case "Expire":
            $status = "Expired";
            break;
        case "CancelAd":
            $status = "Cancelled";
            break;
    }
    echo $status;
    $classified->changeStatus($AdID, $status);
    header('Location: ../history.php');
    endif;
}
?>