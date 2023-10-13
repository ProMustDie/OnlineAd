<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link href="CSS/register.css" rel="stylesheet">
</head>



<body>

    <?php
    include("Includes/navbar.php")
    ?>

    <span id="register">
        <div class="main" id="register">
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="signup m-auto" id="register">
                <form action="#" method="POST" class="needs-validation" novalidate>
                    <label for="chk" aria-hidden="true" id="register">Sign up</label>


                    <input type="text" class="form-control m-auto mb-2" id="validationCustom01" placeholder="Username" name="Username" required style="width:75%;">


                    <input type="text" class="form-control m-auto mb-2" id="validationCustom02" placeholder="Email" name="Email" required style="width:75%;">

                    <input type="password" class="form-control m-auto mb-2" id="validationCustom03" placeholder="Password" name="Password" required style="width:75%;">


                    <input type="password" class="form-control m-auto" id="validationCustom04" placeholder="Repeat_Password" name="Repeat_Password" required style="width:75%;">

                    <label for="error" class="ms-5" style="color:#dc3545;"> sdfsdf<!--//TODO: FOR ERROR VALIDATE--> </label>


                    <input type="submit" name="SignUpSubmit" value="Sign Up" id="register">

                </form>
            </div>

            <div class="login" id="register">
                <form action="#" method="POST" class="needs-validation" novalidate>
                    <label for="chk" aria-hidden="true" id="register">Login</label>


                    <input type="text" class="form-control m-auto mb-2" id="validationCustom05" placeholder="Email" name="EmailLogin" required style="width:75%;">

                    <input type="password" class="form-control m-auto mb-2" id="validationCustom06" placeholder="Password" name="PasswordLogin" required style="width:75%;">

                    <label for="error" class="ms-5" style="color:#dc3545;"> sdfsdf<!--//TODO: FOR ERROR VALIDATE--> </label>


                    <input type="submit" name="LogInSubmit" value="Login" id="register">
                </form>
            </div>
        </div>
    </span>
</body>

</html>

<script src="JS/loginPreference.js"></script>