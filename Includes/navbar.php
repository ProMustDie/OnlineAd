<?php
include_once('includes/RegisterController.php');
include_once('includes/Classified.php');
$classified = new Classified;
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link href="CSS/index.css" rel="stylesheet">

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
                            <a class="nav-link" href="#" data-bs-target="#historyModal" data-bs-toggle="modal">History</a>
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
    <div class="modal fade" id="historyModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1" style="padding-top:10px">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content modal-xl">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">History</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <div class="col bg-light">
                        <div class="row d-flex justify-content-center">
                            <?php
                            $result = $classified->getAds(NULL, NULL, NULL); //Pending Request Approval, Rejected Request, Pending Payment, Rejected Payment, Approved, Cancelled
                            if (mysqli_num_rows($result) > 0) :
                                while ($ads = $result->fetch_assoc()) {
                            ?>

                                    <div class="card m-3" style="width: 30rem;">
                                        <div class="ImgContainer m-2">
                                            <img src="<?= $ads['AdPicture'] ?>" class="imgSize card-img-top img-fluid" alt="..." id="myImg" onclick="openModal('<?= $ads['AdPicture'] ?>', '<?= $ads['AdDescription'] ?>')">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fs-3 fw-bold" id="TextHeader"><?= $ads['AdName'] ?></h5>
                                            <p class="card-text" id="TextSub"><?= $ads['AdDescription'] ?></p>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"></li>
                                                <li class="list-group-item">

                                                    <div class="d-flex  m-2">
                                                        Status: <?= $ads['AdStatus'] ?>
                                                        <div class="container text-end">
                                                            <button class="btn btn-outline-success" data-bs-target="#payment-<?= $ads['AdID'] ?>" data-bs-toggle="modal" aria-labelledby="exampleModalToggleLabel2">Payment</button>
                                                            <button class="btn btn-outline-danger" data-bs-target="#cancel-<?= $ads['AdID'] ?>" data-bs-toggle="modal">Cancel Ad</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                            <?php }
                            endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $result = $classified->getAds(NULL, NULL, NULL); //Pending Request Approval, Rejected Request, Pending Payment, Rejected Payment, Approved, Cancelled
    if (mysqli_num_rows($result) > 0) :
        while ($ads = $result->fetch_assoc()) {
    ?>

            <!--*PAYMENT MODAL-->
            <div class="modal fade" id="payment-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="payment-<?= $ads['AdID'] ?>" tabindex="-1">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="payment-<?= $ads['AdID'] ?>">Payment</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            Pay for: <?= $ads['AdName'] ?>
                            <form action="#" method="#">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload Image</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                                <input type="submit" class="btn btn-outline-success float-end" value="Submit">
                            </form>


                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" data-bs-target="#historyModal" data-bs-toggle="modal">Back to
                                History</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--*PAYMENT MODAL-->

            <!--*DELETE MODAL-->
            <div class="modal fade" id="cancel-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Delete Request</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            Cancel: <?= $ads['AdName'] ?>
                            <form action="#" method="#">
                                <label for="formFile" class="form-label">Are you sure you want to cancel? <br>No refunds will be provided!</label>
                                <div class="container-fluid d-flex justify-content-end">
                                    <input type="submit" class="btn btn-outline-danger mx-2 px-4" value="Yes">
                                    <button type="button" class="btn btn-outline-warning px-4" data-bs-dismiss="modal" aria-label="Close">No</button>
                                </div>
                            </form>


                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" data-bs-target="#historyModal" data-bs-toggle="modal">Back to
                                History</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--*DELETE MODAL-->


    <?php }
    endif; ?>

    <!--//!HISTORY MODAL-->

</body>