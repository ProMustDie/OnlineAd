<?php

include('Includes/app.php');
include_once('Includes/RegisterController.php');

$Err = "";
$pwd = $rptpwd = "";

if (isset($_POST['change-password'])) {

    $selector = $_POST["selector"];
    $validator = $_POST['validator'];
    $pwd = $_POST["password"];
    $rptpwd = $_POST["Rptpassword"];

    if (empty($pwd) || empty($rptpwd)) {
        $Err = "Password cannot be empty!";
    } else if ($pwd != $rptpwd) {
        $Err = "Password is not the same!";
    } else if (!empty($pwd) || !empty($rptpwd)) {
        $currentDate = date("U");

        $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires>=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "Error";
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if (!$row = mysqli_fetch_assoc($result)) {
                $Err = "You need to re-submit your reset request!";
            } else {
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

                if ($tokenCheck === false) {
                    $Err = "You need to re-submit your reset request!";
                } elseif ($tokenCheck === true) {

                    $tokenEmail = $row['pwdResetEmail'];

                    $sql = "SELECT * FROM users WHERE UserEmail=?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "Error";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if (!$row = mysqli_fetch_assoc($result)) {
                            $Err = "An unknown error occured, please try again!";
                        } else {
                            $sql = "UPDATE users SET UserPassword=? WHERE UserEmail=?;";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "Error";
                                exit();
                            } else {
                                $newPwdHash = password_hash($pwd, PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                                mysqli_stmt_execute($stmt);

                                $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                                $stmt = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "Error";
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
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
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/forgotPass.css">
    <title>Reset Password</title>
</head>

<body>
    <?php include('Includes/navbar.php'); ?>


    <div class="container-fluid d-flex justify-content-center align-items-center mb-5" id="forgot">
        <div class="main mt-5" id="forgot" style="height:400px;">

            <div class="login-box" id="forgot">

                <div class="container-fluid pt-5" style="width:80%;">

                    <h2 id="title">Reset Password</h2>
                    <?php
                    if (!empty($_GET['selector']) && !empty($validator = $_GET['validator'])) {
                        $selector = $_GET['selector'];
                        $validator = $_GET['validator'];
                        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                    ?>
                            <form name="SignUp" id="SignUp" action="create-new-password.php?selector=<?= $selector ?>&validator=<?= $validator ?>" method="POST" class="needs-validation" novalidate>
                                <input type="hidden" name="selector" value="<?= $selector ?>">
                                <input type="hidden" name="validator" value="<?= $validator ?>">


                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" placeholder="password" name="password" id="password" required="" value="<?= $pwd; ?>">
                                    <label for="floatingInput text-secondary">New Password</label>
                                </div>

                                <div class="form-floating mb-1">
                                    <input type="password" class="form-control" placeholder="Rptpassword" name="Rptpassword" id="Rptpassword" required="" value="<?= $rptpwd; ?>">
                                    <label for="floatingInput">Repeat Password</label>
                                </div>

                                <div class="user-box">
                                    <span class="text-danger fw-semibold" style="font-size:90%;"><?= $Err; ?></span>
                                    <a href="register.php" class="SignUp float-end fw-semibold">Log In</a>
                                </div>

                                <input type="submit" name="change-password" value="Reset Password" id="submit" class="float-start mt-2">
                            </form>
                    <?php
                        }
                    } else if (empty($selector) || empty($validator)) {
                        echo '<span class="text-danger">Could not validate your request!</span><br>';
                        echo '<a href="forgot.php" class="SignUp">Try Again</a>';
                    }
                    ?>

                </div>

            </div>

        </div>
    </div>



    <?php include('Includes/footer.php'); ?>

</body>

</html>