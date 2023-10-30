<?php
include_once('includes/RegisterController.php');
$logIn = new LoginController;

if (isset($_POST['logout_btn'])) {
    $checkLoggedOut = $logIn->logout();
    if ($checkLoggedOut) {
        echo '<script type="text/javascript">';
        echo 'alert("You are logged out!");';
        echo 'window.location = "main.php";';
        echo '</script>';
    }
}

$key = NULL;
$filter = NULL;
$status = NULL;
if (!empty($_GET['search'])) {
    $key = $_GET['search'];
}
if (!empty($_GET['category'])) {
    $filter = $_GET['category'];
}
if (!empty($_GET['status'])) {
    $status = $_GET['status'];
}
?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link href="CSS/index.css" rel="stylesheet">

<style>
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    footer {
        margin-top: 100%;
    }
</style>

<body>

    <!--navbar-->
    <header>
        <!--Created by © Ausca Lai 2023 & © Teoh Yo Wen 2023 -->
        <nav class="navbar navbar-expand-md navbar-dark fs-3 position-top bg-success">
            <div class="container-fluid">
                <a class="navbar-brand" href="main.php" style="width:80px;">
                    <img src="img/logo.png" alt="" class="img-fluid">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="burger">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto" id="NavSize">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="Main.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="Request.php">Inquiry</a>
                        </li>
                        <?php if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true && $_SESSION['auth_user']['user_type'] != "Admin") : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="history.php" id="History">History</a>
                            </li>

                        <?php
                        endif;
                        if (isset($_SESSION["authenticated"]) && $_SESSION['authenticated'] ==  true) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-expanded="false">
                                    <?= $_SESSION['auth_user']["user_name"] ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end w-50" aria-labelledby="navbarDropdown">
                                    <li>
                                        <form action="" method="POST" class="text-center">
                                            <button type="submit" name="logout_btn" class="btn btn-outline-danger "><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <?php else : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-expanded="false">
                                    Profile
                                </a>
                                <ul class="dropdown-menu text-center dropdown-menu-end mb-2 w-50" aria-labelledby="navbarDropdown">
                                    <li><a type="submit" class="btn btn-outline-primary " href="Register.php"><i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <form class="d-flex" action="" method="GET">
                        <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search" value="<?= $key ?>">
                        <?php
                        if (!empty($filter)) {
                            foreach ($filter as $filtering) { ?>
                                <input type="hidden" name="category[]" value="<?= $filtering ?>">
                            <?php }
                        }
                        if (!empty($status)) {
                            foreach ($status as $stat) { ?>
                                <input type="hidden" name="status[]" value="<?= $stat ?>">
                        <?php }
                        } ?>
                        <button class="btn btn-outline-light" type="submit" style="box-shadow:none;">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <!--navbar-->


</body>