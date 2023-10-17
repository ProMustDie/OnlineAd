<?php
include_once('includes/RegisterController.php');
$logIn = new LoginController;

if (isset($_POST['logout_btn'])) {
    $checkLoggedOut = $logIn->logout();
    if ($checkLoggedOut) {
        header("Location: main.php");
    }
}

$key = NULL;
$filter = NULL;
if (isset($_GET['search'])) {
    $key = $_GET['search'];
}
if (isset($_GET['category'])) {
    $cat = $_GET['category'];
    $filter = implode(" ", $cat);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="CSS/index.css" rel="stylesheet">
</head>

<body>

    <!--navbar-->
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fs-3 position-top bg-success">
            <div class="container-fluid">
                <a class="navbar-brand" href="main.php" style="width:80px;">
                    <img src="img/logo.png" alt="" class="img-fluid">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="burger">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto ">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="Main.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="Request.php">Request</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">History</a>
                        </li>


                        <?php if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true && $_SESSION['auth_user']['user_type'] == "Admin") : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php">Admin</a>
                            </li>
                        <?php endif;

                        if (isset($_SESSION["authenticated"]) && $_SESSION['authenticated'] ==  true) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= $_SESSION['auth_user']["user_name"] ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i> Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="" method="POST" class="text-center">
                                            <button type="submit" name="logout_btn" class="btn btn-outline-primary "><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <?php else : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Profile
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="Register.php"><i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <form class="d-flex" action="" method="GET">
                        <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search" value="<?= $key ?>">
                        <input type="hidden" name="category[]" value="<?= $filter ?>">
                        <button class="btn btn-outline-light" type="submit" style="box-shadow:none;">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <!--navbar-->



    <!--//!HISTORY MODAL-->
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1" style="padding-top:10px">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content modal-xl">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">History</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <div class="col bg-light">
                        <div class="row d-flex justify-content-center">


                            <div class="card m-3" style="width: 30rem;">
                                <div class="ImgContainer m-2">
                                    <img src="img/logo.png" class="imgSize card-img-top img-fluid" alt="..." id="myImg" onclick="openModal('img/logo.png', 'Lorem4000')">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fs-3 fw-bold" id="TextHeader">Card title</h5>
                                    <p class="card-text" id="TextSub">This is a wider card with supporting text below as
                                        a
                                        natural lead-in to
                                        additional content. This content is a little bit longer.</p>


                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"></li>
                                        <li class="list-group-item">

                                            <div class="d-flex  m-2">
                                                Status:Pending
                                                <div class="container text-end">
                                                    <button class="btn btn-outline-success" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Payment</button>
                                                    <button class="btn btn-outline-danger" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal">Delete</button>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card m-3" style="width: 30rem;">
                                <div class="ImgContainer m-2">
                                    <img src="img/logo.png" class="imgSize card-img-top img-fluid" alt="..." id="myImg" onclick="openModal('img/logo.png', 'Lorem4000')">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fs-3 fw-bold" id="TextHeader">Card title</h5>
                                    <p class="card-text" id="TextSub">This is a wider card with supporting text below as
                                        a
                                        natural lead-in to
                                        additional content. This content is a little bit longer.</p>


                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"></li>
                                        <li class="list-group-item">

                                            <div class="d-flex  m-2">
                                                Status:Pending
                                                <div class="container text-end">
                                                    <button class="btn btn-outline-success" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Payment</button>
                                                    <button class="btn btn-outline-danger" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal">Delete</button>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>


    <!--*PAYMENT MODAL-->
    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Payment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    Title:
                    <form action="#" method="#">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload Image</label>
                            <input class="form-control" type="file" id="formFile">
                        </div>
                        <input type="submit" class="btn btn-outline-success float-end" value="Submit">
                    </form>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Back to
                        History</button>
                </div>
            </div>
        </div>
    </div>
    <!--*PAYMENT MODAL-->



    <!--*DELETE MODAL-->
    <div class="modal fade" id="exampleModalToggle3" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Delete Request</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    Title:
                    <form action="#" method="#">
                        <label for="formFile" class="form-label">Are you sure?</label>
                        <div class="container-fluid d-flex justify-content-end">
                            <input type="submit" class="btn btn-outline-danger mx-2 px-4" value="Yes">
                            <input type="submit" class="btn btn-outline-warning px-4" value="No">
                        </div>
                    </form>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Back to
                        History</button>
                </div>
            </div>
        </div>
    </div>
    <!--*DELETE MODAL-->

    <!--//!HISTORY MODAL-->

</body>

</html>