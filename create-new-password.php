<?php

include('Includes/app.php');
include_once('Includes/RegisterController.php');

$Err = "";
$pwd = $rptpwd = "";

if(isset($_POST['change-password'])){

    $selector = $_POST["selector"];
    $validator = $_POST['validator'];
    $pwd = $_POST["password"];
    $rptpwd = $_POST["Rptpassword"];

    if(empty($pwd)||empty($rptpwd)){
        $Err = "Password cannot be empty!";
    }else if ($pwd != $rptpwd){
        $Err = "Password is not the same!";
    }else if(!empty($pwd)||!empty($rptpwd)){
    $currentDate = date("U");

    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires>=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "Error";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt,"ss",$selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if(!$row = mysqli_fetch_assoc($result)){
            $Err = "You need to re-submit your reset request!";
        }else{
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

            if($tokenCheck === false){
                $Err = "You need to re-submit your reset request!";
            }elseif($tokenCheck === true){

                $tokenEmail = $row['pwdResetEmail'];

                $sql = "SELECT * FROM users WHERE UserEmail=?;";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    echo "Error";
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt,"s",$tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if(!$row = mysqli_fetch_assoc($result)){
                        $Err = "An unknown error occured, please try again!";
                    }else{
                        $sql = "UPDATE users SET UserPassword=? WHERE UserEmail=?;";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            echo "Error";
                            exit();
                        }else{
                            $newPwdHash = password_hash($pwd, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt,"ss",$newPwdHash,$tokenEmail);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                echo "Error";
                                exit();
                            }else{
                                mysqli_stmt_bind_param($stmt,"s",$tokenEmail);
                                mysqli_stmt_execute($stmt);
                                header("Location: register.php?newpwd=passwordupdated");
                            } 
                        }
                            
                        }
                    }

                }
            }
        }
    }
 }




?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/navbar.css">
    <title>Reset Password</title>
</head>

<body>
<?php include('Includes/navbar.php'); ?>
<div class="centering">
    <div class="login-box">
        <h2>Reset Password</h2>
        <?php 
        if(!empty($_GET['selector']) && !empty($validator = $_GET['validator'])){
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];
            if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ){
                ?>
        <form name="SignUp" id="SignUp" action="create-new-password.php?selector=<?=$selector?>&validator=<?=$validator?>" method="POST">
            <input type="hidden" name="selector" value= "<?=$selector?>">
            <input type="hidden" name="validator" value= "<?=$validator?>">
            <div class="user-box">
                <input type="password" name="password" id="password" required="" value="<?= $pwd; ?>">
                <label>Password<span class="error">*</span></label>
            </div>

            <div class="user-box">
                <input type="password" name="Rptpassword" id="Rptpassword" required="" value="<?= $rptpwd; ?>">
                <label>Repeat Password<span class="error">*</span></label>
            </div>




            <div class="user-box">
                <span class="error"><?= $Err; ?></span>
                <a href="login.php" class="SignUp">Log In</a>
            </div>

            <input type="submit" id="submit" name="change-password" value="Reset Password">

        </form>
        <?php
            }
        }else if(empty($selector)||empty($validator)){
            echo '<span class="error">Could not validate your request!</span>';
            echo '<a href="forgot.php" class="SignUp">Try Again</a>';
        }
        ?>
    </div>
</div>
  </div>
</body>

</html>