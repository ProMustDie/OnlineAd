<?php

include('includes/app.php');
include_once('includes/RegisterController.php');


$registerErr = $loginErr = "";
$loginEmail = $email = $password = $rpt_password = $username = "";
$ValidSignUp = false;
$logIn = new LoginController;
$Register = new RegisterController;
$redirect = empty($_GET['redirect']) ? "Main.php" : $_GET['redirect'];


if (isset($_POST["LogInSubmit"])) {

    $loginEmail = empty($_POST["EmailLogin"]) ? "" : $_POST["EmailLogin"];
    $password = empty($_POST["PasswordLogin"]) ? "" : $_POST["PasswordLogin"];

    $login_query = $logIn->login($loginEmail, $password);
    if ($login_query) {
        echo '<script type="text/javascript">';
        echo 'alert("You are now logged in!");';
        echo 'window.location = "' . $redirect . '";';
        echo '</script>';
    } else {
        $loginErr = "Invalid Email or Password";
    }
}

if (isset($_POST["SignUpSubmit"])) {

    if (!empty($_POST["Username"]) && !empty($_POST["Email"]) && !empty($_POST["pwd"]) && !empty($_POST["rpt_pwd"])) {
        $username = $_POST["Username"];
        $email = $_POST["Email"];
        $password = $_POST["pwd"];
        $rpt_password = $_POST["rpt_pwd"];

        $ValidSignUp = true;
    } else {
        $registerErr = "Please fill in all required fields!";
        $ValidSignUp = false;
    }

    if ($ValidSignUp == true && $Register->isMaxChar15($username)) {
        $registerErr = "Username must not be more than 15 characters";
        $ValidSignUp = false;
    } elseif ($ValidSignUp == false) {
        $ValidSignUp = false;
    } elseif (!($Register->isMaxChar15($username))) {
        $ValidSignUp = true;
    }

    if ($ValidSignUp == true && $Register->isUsernameExist($username)) {
        $registerErr = "This Username is taken!";
        $ValidSignUp = false;
    } elseif ($ValidSignUp == false) {
        $ValidSignUp = false;
    } elseif (!($Register->isUsernameExist($username))) {
        $ValidSignUp = true;
    }

    if ($ValidSignUp == true && $Register->isEmailExist($email)) {
        $registerErr = "This Email has been used!";
        $ValidSignUp = false;
    } elseif ($ValidSignUp == false) {
        $ValidSignUp = false;
    } elseif (!($Register->isEmailExist($email))) {
        $ValidSignUp = true;
    }

    if ($ValidSignUp == true && $password != $rpt_password) {
        $registerErr = "Password does not match!";
        $ValidSignUp = false;
    } elseif ($ValidSignUp == false) {
        $ValidSignUp = false;
    } elseif ($password = $rpt_password) {
        $ValidSignUp = true;
    }

    if ($ValidSignUp == true) {
        $password = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
        if ($Register->registration($username, $email, $password)) {
            echo '<script type="text/javascript">';
            echo 'alert("Successfully signed up, you may now log in.");';
            echo 'window.location = "register.php";';
            echo '</script>';
        } else {
            $registerErr = "Account Creation Error!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link href="CSS/register.css" rel="stylesheet">
</head>

<html>

<body>

    <?php
    include("Includes/navbar.php")
    ?>


    <div class="container-fluid d-flex justify-content-center align-items-center" id="register">
        <div class="main mt-5" id="register">
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="signup m-auto" id="register">
                <form action="#" method="POST" class="needs-validation" novalidate>
                    <label for="chk" aria-hidden="true" id="register">Sign up</label>


                    <input type="text" class="form-control m-auto mb-2" id="validationCustom01" placeholder="Username" name="Username" value="<?= $username ?>" required style="width:75%;">


                    <input type="email" class="form-control m-auto mb-2" id="validationCustom02" placeholder="Email" name="Email" value="<?= $email ?>" required style="width:75%;">

                    <input type="password" class="form-control m-auto mb-2" id="validationCustom03" placeholder="Password" name="pwd" required style="width:75%;">


                    <input type="password" class="form-control m-auto" id="validationCustom04" placeholder="Repeat Password" name="rpt_pwd" required style="width:75%;">

                    <label for="error" class="ms-5" style="color:#dc3545;"><?= $registerErr ?></label>


                    <input type="submit" name="SignUpSubmit" value="Sign Up" id="register">

                </form>
            </div>

            <div class="login" id="register">
                <form action="#" method="POST" class="needs-validation" novalidate>
                    <label for="chk" aria-hidden="true" id="register">Login</label>


                    <input type="text" class="form-control m-auto mb-2" id="validationCustom05" placeholder="Email" name="EmailLogin" value="<?= $loginEmail ?>" required style="width:75%;">

                    <input type="password" class="form-control m-auto mb-2" id="validationCustom06" placeholder="Password" name="PasswordLogin" required style="width:75%;">

                    <label for="error" class="ms-5" style="color:#dc3545;"><?= $loginErr ?></label>

                    <a href="#" class="p-0 m-0 mb-2">Forgot Password</a>
                    <input type="submit" name="LogInSubmit" value="Login" id="register">
                </form>

            </div>
        </div>
    </div>





    <script src="JS/loginPreference.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>