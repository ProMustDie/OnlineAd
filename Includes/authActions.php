<?php
include('app.php');
include_once 'Classified.php';
include_once 'RegisterController.php';
include('mail.php');

$classified = new Classified;
$usersystem = new LoginController();

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
                send_mail($classified->getAuthorEmail($AdID), $classified->getAuthorName($AdID),"AD REQUEST REJECTED","Ad request for: \"".$classified->getAdName($AdID)."\" has been rejected!");
                break;
            case "AcceptRequest":
                $status = "Pending Payment";
                $price = empty($_POST['Price'])? NULL : $_POST['Price'];
                $classified->setPrice($AdID, $price);
                send_mail($classified->getAuthorEmail($AdID), $classified->getAuthorName($AdID),"AD REQUEST ACCEPTED","Ad request for: \"".$classified->getAdName($AdID)."\" has been accepted!\nPlease pay RM".$price." and upload the receipt in our website.");
                break;
            case "RejectPayment":
                $status = "Rejected Payment";
                send_mail($classified->getAuthorEmail($AdID), $classified->getAuthorName($AdID),"AD PAYMENT REJECT","Ad payment for: \"".$classified->getAdName($AdID)."\" has been rejected!\nPlease resubmit you receipt again in our website.");
                break;
            case "ApproveAd":
                $status = "Approved";
                $classified->setPostTimeNOW($AdID);
                send_mail($classified->getAuthorEmail($AdID), $classified->getAuthorName($AdID),"AD APPROVED","Ad \"".$classified->getAdName($AdID)."\" has its payment approved!");
                break;
            case "Expire":
                $status = "Expired";
                break;
            case "CancelAd":
                $status = "Cancelled";
                send_mail($classified->getAuthorEmail($AdID), $classified->getAuthorName($AdID),"AD CANCELLED","Ad \"".$classified->getAdName($AdID)."\" has been cancelled!\nContact customer support if there are any enquiries.");
                break;
        }
        $classified->changeStatus($AdID, $status);
        header("Location: ../$redirect"); 
    endif;
    }

    if($requests=="editUserType"){
        $redirect= $_GET['redirect'];
        $userID= $_POST['admin-select-user-id'];
        $typeChange = $_POST['admin-select-acctype'];
        if($usersystem->editUserType($userID,$typeChange)){
            header("Location: ../$redirect");
        };
    }

    if($requests=="getusertype"){
        $userID= $_GET['userID'];
        $result = $classified->getusertype($userID);
        echo $result;
    }
    
    if($requests=="addremovecat"){
        $addCat = $_POST['add-cat'];
        $delCat = $_POST['del-cat'];
        $alertMsg = "";

        if(!empty($addCat)){
            if(!$classified->catIsDuplicate($addCat)){
                if($classified->addCategory($addCat)){
                    $alertMsg.="\"$addCat\" added to category. ";
                }else{
                    $alertMsg.="\"$addCat\" failed to be added. ";
                }
            }else{
                $alertMsg.="\"$addCat\" already exists. ";
            }
        }

        if($delCat != "None"){
            if($classified->delCategory($delCat)){
                $alertMsg.="\"$delCat\" category deleted. ";
            }else{
                $alertMsg.="\"$delCat\" failed to delete. ";
            }
        }

        elseif(empty($addCat) && $delCat=="None"){
            $alertMsg.="No inputs were given!";
        }
 
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
            send_mail($classified->getAuthorEmail($AdID), $classified->getAuthorName($AdID),"AD CANCELLED","Ad \"".$classified->getAdName($AdID)."\" has been cancelled!\nContact customer support if there are any enquiries.");
            break;
    }
    $classified->changeStatus($AdID, $status);
    header("Location: ../$redirect"); 
    endif;
}
?>