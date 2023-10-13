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

            <div class="signup" id="register">
                <form>
                    <label for="chk" aria-hidden="true" id="register">Sign up</label>
                    <input type="text" name="txt" placeholder="User name" required="" id="register">
                    <input type="email" name="email" placeholder="Email" required="" id="register">
                    <input type="password" name="pswd" placeholder="Password" required="" id="register">
                    <button id="register">Sign up</button>
                </form>
            </div>

            <div class="login" id="register">
                <form>
                    <label for="chk" aria-hidden="true" id="register">Login</label>
                    <input type="email" name="email" placeholder="Email" required="" id="register">
                    <input type="password" name="pswd" placeholder="Password" required="" id="register">
                    <button id="register">Login</button>
                </form>
            </div>
        </div>
    </span>
</body>

</html>