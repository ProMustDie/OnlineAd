<?php
include_once('includes/RegisterController.php');
include_once('includes/Classified.php');
$logIn = new LoginController;
$page_system = new Classified;
$redirect2 = basename($_SERVER['PHP_SELF']);

if (!empty($_SERVER['QUERY_STRING'])) {
    $redirect2 .= '?' . $_SERVER['QUERY_STRING'];
}

if (isset($_POST['logout_btn'])) {
    $checkLoggedOut = $logIn->logout();
    if ($checkLoggedOut) {
        echo '<script type="text/javascript">';
        echo 'alert("You are logged out!");';
        echo 'window.location = "main.php";';
        echo '</script>';
    }
}

//Paging system initializer
if (isset($_GET['page']) && $_GET['page'] != "") {
    $page_no = $_GET['page'];
} else {
    $page_no = 1;
}

$prev_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

//End Paging System initializer

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
<link rel="stylesheet" href="CSS/virtual-select.min.css">
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

<body class="bg-light">

    <!--Move Up Button-->
    <a class="btn btn-outline-dark rounded-pill btn-floating text-center m-0 p-0 opacity-75" id="buttonUp"></a>

    <!--LOADING SCREEN-->
    <div class="loader loader-hidden"></div>


    <!--navbar-->
    <header>

        <!--TOP NAV-->
        <nav class="navbar bg-light m-0 p-0" id="topnav">
            <div class="container-fluid">

                <div style="width:8rem; height:4.5rem;">
                    <a class="navbar-brand w-auto h-auto" href="main.php">
                        <img src="img/logo.png" alt="Logo" class="d-inline-block align-text-top m-auto p-0 img-fluid">
                    </a>
                </div>

                <div class="ms-auto d-inline">
                    <?php
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $currentDate = date('D, M j, Y');
                    ?>

                    <span><?=$currentDate?> </span>
                    <!-- Section: Social media -->

                    <!-- Facebook -->
                    <a class="btn btn-outline-dark btn-floating m-1" href="https://www.facebook.com/thesundaily" role="button"><i class="bi bi-facebook"></i></a>

                    <!-- Twitter -->
                    <a class="btn btn-outline-dark btn-floating m-1" href="https://twitter.com/thesundaily" role="button"><i class="bi bi-twitter-x"></i></a>

                    <!-- Google -->
                    <a class="btn btn-outline-dark btn-floating m-1" href="https://www.instagram.com/thesundaily/" role="button"><i class="bi bi-instagram"></i></a>

                    <!-- Instagram -->
                    <a class="btn btn-outline-dark btn-floating m-1" href="https://www.youtube.com/channel/UCJNLiW1NkgyHeoijxH-a_Wg" role="button"><i class="bi bi-youtube"></i></a>

                    <!-- Linkedin -->
                    <a class="btn btn-outline-dark btn-floating m-1" href="https://www.tiktok.com/@thesundaily?lang=en" role="button"><i class="bi bi-tiktok"></i></a>

                    <!-- Github -->
                    <a class="btn btn-outline-dark btn-floating m-1" href="https://t.me/thesuntelegram" role="button"><i class="bi bi-telegram"></i></a>

                    <a class="btn btn-outline-dark btn-floating m-1" href="https://ipaper.thesundaily.my/epaper/viewer.aspx?publication=The%20Sun%20Daily" role="button">
                        <img src="https://www.thesundaily.my/base-portlet/webrsrc/theme/5d54942b1f61e0b83545fbac4d992dab.png" class="bi" width="24" height="24" alt="Custom Image">
                    </a>

                    <!-- Section: Social media -->

                </div>

            </div>
        </nav>




        <!--Created by © Ausca Lai 2023 & © Teoh Yo Wen 2023 -->
        <!--BTM NAV-->
        <nav class="navbar navbar-expand-md navbar-dark fs-3 bg-success m-0 pb-2" id="BtmNav">
            <div class="container-fluid">
                <a class="navbar-brand" href="main.php" style="width:60px;" id="BtmNavImg">
                    <img src="img/logo.png" alt="" class="img-fluid">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="burger">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="height:50px;">
                    <ul class="navbar-nav me-auto" id="NavSize">
                        <li class="nav-item">
                            <a class="nav-link active fs-4" aria-current="page" href="Main.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fs-4" href="Request.php">Inquiry</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-4" href="#">Analytics</a>
                        </li>
                        <?php if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true && $_SESSION['auth_user']['user_type'] != "Admin") : ?>
                            <li class="nav-item">
                                <a class="nav-link fs-4" href="history.php" id="History">History</a>
                            </li>

                        <?php
                        endif;
                        if (isset($_SESSION["authenticated"]) && $_SESSION['authenticated'] ==  true) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fs-4" href="#" id="navbarDropdown" role="button" aria-expanded="false">
                                    <?= $_SESSION['auth_user']["user_name"] ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end mb-2 bg-light" aria-labelledby="navbarDropdown">
                                    <?php if ($_SESSION['auth_user']['user_type'] == "Admin") : ?>
                                        <li>
                                            <div class="text-center">
                                                <button class="btn btn-outline-dark" data-bs-target="#EditUserType" data-bs-toggle="modal">Edit Users</button>
                                            </div>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <form action="" method="POST" class="text-center">
                                            <button type="submit" name="logout_btn" class="btn btn-outline-danger "><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <?php else : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fs-4" href="#" id="navbarDropdown" role="button" aria-expanded="false">
                                    Profile
                                </a>
                                <ul class="dropdown-menu text-center dropdown-menu-end mb-2 w-50" aria-labelledby="navbarDropdown">
                                    <li><a type="submit" class="btn btn-outline-primary " href="Register.php"><i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <form class="d-flex" action="" method="GET" style="height: 40px;">
                        <input class="form-control me-2 py-1 pb-2" type="search" placeholder="Search" name="search" aria-label="Search" value="<?= $key ?>">
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
                        <button type="submit" class="btn btn-outline-light btn-sm">Search</button>

                    </form>
                </div>
            </div>
        </nav>
    </header>

    <div class="container" id="space"></div>
    <!--navbar-->

    <?php if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['user_type'] == "Admin") : ?>

        <!--// EDIT USER MODAL-->
        <div class="modal fade p-0" id="EditUserType" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-md modal-dialog-centered mt-1">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3 fw-semibold" id="edit">Edit Users</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="Includes/authActions.php?request=editUserType" method="POST">
                            <span class="fw-semibold">User:</span>
                            <div id="admin-user-select"></div><br><br>
                            <span class="fw-semibold">Account Type:</span>
                            <div id="admin-acctype-select"></div>
                            </h2><br>
                            <br>
                            <input type="hidden" value="<?= $redirect2 ?>" name="redirect">
                            <input type="hidden" value="EditUserType" name="modalID">
                            <button type="submit" name="updateUser" class="btn btn-outline-success mt-4 px-4 float-end"><i class="fa-solid fa-pen-to-square"></i> Update User</button><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--// EDIT USER MODAL-->

        <script src="JS/virtual-select.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                VirtualSelect.init({
                    ele: "#admin-user-select",
                    options: [
                        <?php
                        $classified2 = new Classified();
                        $result = $classified2->getUsersList($_SESSION['auth_user']['user_id']);
                        while ($member = $result->fetch_assoc()) { ?> {
                                label: "<?= $member['UserName'] ?>, <?= $member['UserEmail'] ?>",
                                value: "<?= $member['UserID'] ?>"
                            },
                        <?php } ?>
                    ],
                    search: true,
                    required: true,
                    noSearchResultsText: "No Users Found",
                    searchPlaceholderText: "Seach Users...",
                    placeholder: "Select Users",
                    name: "admin-select-user-id",
                });
                VirtualSelect.init({
                    ele: "#admin-acctype-select",
                    options: [{
                            label: "Admin",
                            value: "Admin"
                        },
                        {
                            label: "User",
                            value: "User"
                        },
                    ],
                    required: true,
                    placeholder: "Select Account Type",
                    name: "admin-select-acctype",
                });
            });
        </script>
        <script>
            function checknUpdateAccType(userId) {
                fetch(`Includes/authActions.php?request=getusertype&userID=${userId}`)
                    .then(response => response.text())
                    .then(accType => {
                        console.log(accType);
                        if (accType && accType.trim() == "Admin") {
                            document.querySelector('#admin-acctype-select').setValue("Admin");
                        } else {
                            document.querySelector('#admin-acctype-select').setValue("User");
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching user type:', error);
                    });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const adminUserSelect = document.querySelector('#admin-user-select');
                adminUserSelect.addEventListener('change', function() {
                    const adminUserSelectedId = adminUserSelect.value;
                    checknUpdateAccType(adminUserSelectedId);
                });
            });
        </script>
    <?php endif; ?>