<?php include('includes/app.php');
include_once('includes/Classified.php');
$classified = new Classified;
include('Includes/AuthController.php');
$redirect = basename($_SERVER['PHP_SELF']);
if (!empty($_SERVER['QUERY_STRING'])) {
    $redirect .= '?' . $_SERVER['QUERY_STRING'];
}
$AuthLogin = new AuthenticatorController($redirect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="CSS/main.css" rel="stylesheet">
    <title>Inquiry</title>
</head>

<body class="bg-light">

    <?php
    include("Includes/navbar.php");
    ?>


    <?php if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true && $_SESSION['auth_user']['user_type'] != "Admin") : ?>
        <!--Request -->

        <div class="container  p-5 bg-light ">
            <div class="row ">
                <div class="col ">
                    <u style="text-decoration-thickness: 2px; color:gray">
                        <h2 class="text-center text-secondary mb-3">Inquiry Form Submission</h2>
                    </u>
                    <form action="Includes/RequestAds.php" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">


                        <input type="hidden" name="UserID" value="<?= $_SESSION['auth_user']['user_id'] ?>">
                        <input type="hidden" name="redirect" value="<?= $redirect ?>">

                        <input type="file" class="form-control m-auto mb-2" id="validationCustom01" name="fileUpload" style="width:75%;" required accept="image/png, image/jpeg, image/jpg, application/pdf">

                        <input type="text" class="form-control m-auto mb-2" id="validationCustom02" placeholder="Title" name="title" required style="width:75%;">

                        <textarea class="form-control  m-auto mb-2" id="validationTextarea01" placeholder="Description" style="width:75%;" rows="2" name="description"></textarea>


                        <!--//! Need to use php to validate atleast 1 category is chosen -->
                        <div class="container text-start p-0" style="width:75%;">

                            <label>Categories</label><span class="text-danger"> *Choose Minimum 1</span>

                            <?php
                            $categoriesData = $classified->getCategories();
                            $result = $categoriesData['result'];

                            if (mysqli_num_rows($result) > 0) :
                                while ($categories = $result->fetch_assoc()) {
                                    $categoryName = $categories["Category"];
                            ?>
                                    <div class="checkbox-wrapper-4">
                                        <input class="inp-cbx" id="<?= $categoryName ?>" type="checkbox" name="category[]" value="<?= $categoryName ?>" />
                                        <label class="cbx m-auto" for="<?= $categoryName ?>"><span>
                                                <svg width="12px" height="10px">
                                                    <use xlink:href="#check-4"></use>
                                                </svg></span><span><?= $categoryName ?></span></label>
                                        <svg class="inline-svg">
                                            <symbol id="check-4" viewbox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </symbol>
                                        </svg>
                                    </div>
                            <?php }
                            endif; ?>
                        </div>
                        <!--//! Need to use php to validate atleast 1 category is chosen -->




                        <!--//! ADDITIONAL INFO
                         <textarea class="form-control  m-auto mb-2" id="validationTextarea02" placeholder="Note to Admin" style="width:75%;" rows="2" name="ExtraInfo"></textarea>
                        -->



                        <input type="submit" name="RequestSubmit" value="Request" id="request">

                    </form>
                </div>
            </div>
        </div>

        <!--Request -->

    <?php elseif (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true && $_SESSION['auth_user']['user_type'] == "Admin") : ?>



        <!--//! ADMIN -->

        <div class="container-fluid bg-light p-0 m-0">

            <!--//!Category-->
            <div class="row m-0 p-0">


                <div class="col-sm-4 col-md-3 col-xl-2 m-0 p-0">

                    <nav class="navbar navbar-expand-sm bg-body-tertiary">
                        <div class="container-fluid pe-0">
                            <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span><span style="position:relative; top:2px;">Filter</span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                                <form action="" method="GET" class="mx-auto">
                                    <div class="text-center ms-2 mt-3 ">
                                        <b class="fs-3">Categories</b>
                                        <hr>
                                        <div class="text-start">

                                            <?php
                                            $categoriesData = $classified->getCategories();
                                            $result = $categoriesData['result'];
                                            $selectedCategories = $categoriesData['selectedCategories'];

                                            if (mysqli_num_rows($result) > 0) :
                                                while ($categories = $result->fetch_assoc()) {
                                                    $categoryName = $categories["Category"];
                                                    $isChecked = in_array($categoryName, $selectedCategories) ? 'checked' : '';
                                            ?>
                                                    <div class="checkbox-wrapper-4" id="CateText">
                                                        <input class="inp-cbx" id="<?= $categoryName ?>" type="checkbox" name="category[]" value="<?= $categoryName ?>" <?= $isChecked ?> />
                                                        <label class="cbx" for="<?= $categoryName ?>"><span>
                                                                <svg width="12px" height="10px">
                                                                    <use xlink:href="#check-4"></use>
                                                                </svg></span><span><?= $categoryName ?></span></label>
                                                        <svg class="inline-svg">
                                                            <symbol id="check-4" viewbox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </symbol>
                                                        </svg>
                                                    </div>
                                            <?php
                                                }
                                            endif;
                                            ?>
                                        </div>
                                    </div>

                                    <div class="text-center ms-2 mt-3 ">
                                        <b class="fs-3">Status</b>
                                        <hr>
                                        <div class="text-start">
                                            <?php
                                            $statusData = $classified->getStatus();
                                            $result = $statusData['result'];
                                            $selectedStatus = $statusData['selectedStatus'];

                                            if (mysqli_num_rows($result) > 0) :
                                                while ($stat = $result->fetch_assoc()) {
                                                    $statusName = $stat["AdStatus"];
                                                    $isChecked = in_array($statusName, $selectedStatus) ? 'checked' : '';
                                            ?>

                                                    <div class="checkbox-wrapper-4 ms-1" id="CateText">
                                                        <input class="inp-cbx" id="<?= $statusName ?>" type="checkbox" name="status[]" value="<?= $statusName ?>" <?= $isChecked ?> />
                                                        <label class="cbx" for="<?= $statusName ?>"><span>
                                                                <svg width="12px" height="10px">
                                                                    <use xlink:href="#check-4"></use>
                                                                </svg></span><span><?= $statusName ?></span></label>
                                                        <svg class="inline-svg">
                                                            <symbol id="check-4" viewbox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </symbol>
                                                        </svg>
                                                    </div>
                                            <?php
                                                }
                                            endif;
                                            ?>


                                        </div>







                                        <?php if (!empty($_GET['search'])) { ?>
                                            <input type="hidden" name="search" value="<?= $key ?>">
                                        <?php } ?>
                                        <input type="submit" class="button-31 mt-5 mb-3" value="Search">

                                    </div>
                                    <div class="text-center">
                                        <a class="btn btn-outline-dark btn-floating w-75 ms-2" data-bs-target="#addcate" data-bs-toggle="modal"><i class="bi bi-plus-slash-minus fs-6"> Category</i></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>

                <!--//!Category-->

                <div class="col bg-light">

                    <div class="row d-flex justify-content-center">

                        <?php
                        $result = $classified->getAds($key, $filter, $status, NULL);
                        if (mysqli_num_rows($result) > 0) :
                            while ($ads = $result->fetch_assoc()) {
                                $datetime = new DateTime($ads['AdPostedDateTime']);
                                $formattedDatetime = $datetime->format('h:iA d/m/Y');
                        ?>

                                <div class="card m-2" style="width: 18rem;">
                                    <div class="ImgContainer m-2">
                                        <img src="<?= $ads['AdPicture'] ?>" class="imgSize card-img-top " id="myImg" data-bs-toggle="modal" data-bs-target="#modalImg-<?= $ads['AdID'] ?>">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title fs-5 fw-bold text-truncate" id="TextHeader" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="<?= $ads['AdName'] ?>"><?= $ads['AdName'] ?></h5>

                                        <p class="card-text text-truncate text-secondary " id="TextSub" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="<?= $ads['AdDescription'] ?>">
                                            <small> <?= $ads['AdDescription'] ?></small><br>
                                        </p>
                                        <div class="dropdown d-inline">
                                            <button class="btn btn-sm btn-success dropdown-toggle" type="button" aria-expanded="false">
                                                Category
                                            </button>
                                            <div class="dropdown-menu p-2 mt-1 rounded-3 bg-secondary-subtle" style="width:250%;">
                                                <p class="card-text lh-lg" id="TextCate">
                                                    <?php
                                                    $categoriesArray = explode(',', $ads['AdCategory']);
                                                    foreach ($categoriesArray as $category) {

                                                    ?>

                                                        <span class="rounded-3 bg-success text-light px-2 py-1"><?= $category ?></span>


                                                    <?php } ?>
                                                </p>
                                            </div>
                                        </div>



                                        <ul class="list-group list-group-flush">

                                            <li class="list-group-item p-0 m-0 ">

                                                <div class="d-flex m-2 ">

                                            <li class="list-group-item p-0 m-0 border-0">
                                                <p class="card-text mb-1" id="TextTime"><small class="text-muted">
                                                        <p class="card-text" id="TextTime"><small class="text-muted"><?php if ($ads['AdStatus'] == "Expired" || $ads['AdStatus'] == "Cancelled" || $ads['AdStatus'] == "Approved") : echo  $ads['UserName'] . " posted at " . $formattedDatetime;
                                                                                                                        else : echo $ads['UserName'] . " requested at " . $formattedDatetime;
                                                                                                                        endif; ?></small></p>
                                                    </small></p>
                                            </li>


                                            <div class="container-fluid p-0 d-inline-flex align-items-center mb-2">
                                                Status:
                                                <?php switch ($ads['AdStatus']) {
                                                    case "Pending Review":
                                                    case "Pending Payment":
                                                    case "Checking Payment":
                                                        echo '<span class="text-warning" style:"width:150px;">';
                                                        break;
                                                    case "Rejected Request":
                                                    case "Rejected Payment":
                                                    case "Cancelled":
                                                    case "Expired":
                                                        echo '<span class="text-danger" style:"width:150px;">';
                                                        break;
                                                    case "Approved":
                                                        echo '<span class="text-success" style:"width:150px;">';
                                                        break;
                                                }
                                                echo "&nbsp;" . $ads['AdStatus'];
                                                ?>
                                                </span>
                                            </div>

                                            <?php if ($ads['AdStatus'] != "Expired" && $ads['AdStatus'] != "Rejected Request" && $ads['AdStatus'] != "Cancelled") : ?>
                                                <li class="list-group-item p-0 m-0 border-bottom-0">
                                                    <div class="container-fluid p-0 text-end">
                                                        <button class="btn btn-outline-dark btn-floating m-1" data-bs-target="#modalEdit-<?= $ads['AdID'] ?>" data-bs-toggle="modal" role="button"><i class="bi bi-pen"></i>


                                                            <?php if ((isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true && $_SESSION['auth_user']['user_type'] == "Admin") && (($ads['AdStatus'] == "Pending Review") || ($ads['AdStatus'] == "Checking Payment"))) { ?>
                                                                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                                                    <span class="visually-hidden">New alerts</span>
                                                                </span>
                                                            <?php } ?>



                                                        </button>
                                                    </div>
                                                <?php endif; ?>

                                    </div>
                                    </li>

                                    </ul>
                                </div>

                                <!--//!MODAL FOR IMAGES POPUP-->

                                <div class="modal fade p-0" id="modalImg-<?= $ads['AdID'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl  mt-1">
                                        <div class="modal-content modal-xl">
                                            <div class="modal-header p-3">

                                                <div class="col">
                                                    <div class="item1">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin-left: 95%;"></button>
                                                    </div>
                                                    <div class="item2">
                                                        <h1 class="modal-title fs-5 fw-semibold" id="exampleModalLabel"><?= $ads['AdName'] ?></h1>
                                                    </div>
                                                    <div class="item3">
                                                        <span class="text-muted mx-auto"><small><?= $ads['UserName'] . " posted on " . $formattedDatetime ?></small></span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                                <img class="modal-content" id="modalImg" src="<?= $ads['AdPicture'] ?>">
                                            </div>
                                            <div class="modal-footer">


                                                <div class="container text-center text-break" id="caption">
                                                    <p class="card-text lh-lg" id="TextCate">
                                                        <?php
                                                        $categoriesArray = explode(',', $ads['AdCategory']);
                                                        foreach ($categoriesArray as $category) {

                                                        ?>

                                                            <span class="rounded-3 bg-success text-light px-2 py-1"><?= $category ?></span>


                                                        <?php } ?>
                                                    </p>
                                                </div>
                                                <div class="container text-center text-break m-auto" id="caption"><?= $ads['AdDescription'] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <?php if ($ads['AdStatus'] != "Expired" && $ads['AdStatus'] != "Rejected Request" && $ads['AdStatus'] != "Cancelled") : ?>
                                    <!--//!MODAL FOR Edit Buttons POPUP-->

                                    <div class="modal fade p-0" id="modalEdit-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="edit" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered mt-1">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-3 fw-semibold" id="edit">Edit</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php if ($ads['AdStatus'] == "Pending Review") : ?>
                                                        <button class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#acceptRequest-<?= $ads['AdID'] ?>">Accept Request</button>
                                                        <button class="btn btn-outline-danger mb-2" data-bs-toggle="modal" data-bs-target="#rejectRequest-<?= $ads['AdID'] ?>">Reject Request</button>
                                                    <?php endif;
                                                    if ($ads['AdStatus'] == "Checking Payment") :
                                                    ?>
                                                        <button class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#acceptPayment-<?= $ads['AdID'] ?>">Accept Payment</button>
                                                        <button class="btn btn-outline-danger mb-2" data-bs-toggle="modal" data-bs-target="#rejectPayment-<?= $ads['AdID'] ?>">Reject Payment</button>
                                                        <button class="btn btn-outline-success mb-2" data-bs-toggle="modal" data-bs-target="#Receipt-<?= $ads['AdID'] ?>">Check Payment</button>
                                                    <?php
                                                    endif;
                                                    if ($ads['AdStatus'] != "Expired" && $ads['AdStatus'] != "Rejected Request" && $ads['AdStatus'] != "Cancelled") : ?>
                                                        <button class="btn btn-outline-danger mb-2" data-bs-target="#cancel-<?= $ads['AdID'] ?>" data-bs-toggle="modal">Cancel Ad</button>
                                                        <button class="btn btn-outline-secondary mb-2" data-bs-target="#edit-<?= $ads['AdID'] ?>" data-bs-toggle="modal">Edit Ad</button>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="modal-footer d-flex justify-content-between">

                                                    <div class="text-start mb-2 p-0"> <span class="fw-semibold">Title:</span><?= $ads['AdName'] ?></div>
                                                    <div class="p-0  mb-2">

                                                        Status:
                                                        <?php switch ($ads['AdStatus']) {
                                                            case "Pending Review":
                                                            case "Pending Payment":
                                                            case "Checking Payment":
                                                                echo '<span class="text-warning" style:"width:150px;">';
                                                                break;
                                                            case "Rejected Request":
                                                            case "Rejected Payment":
                                                            case "Cancelled":
                                                            case "Expired":
                                                                echo '<span class="text-danger" style:"width:150px;">';
                                                                break;
                                                            case "Approved":
                                                                echo '<span class="text-success" style:"width:150px;">';
                                                                break;
                                                        }
                                                        echo "&nbsp;" . $ads['AdStatus'];
                                                        ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <?php if ($ads['AdStatus'] == "Checking Payment") : ?>
                                        <!--//!MODAL FOR RECEIPT PAYMENT POPUP-->

                                        <div class="modal fade p-0" id="Receipt-<?= $ads['AdID'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                            <div class="modal-dialog modal-xl mt-4">
                                                <div class="modal-content modal-xl">
                                                    <div class="modal-header p-3">

                                                        <div class="col">
                                                            <div class="item1">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin-left: 95%;"></button>
                                                            </div>
                                                            <div class="item2">
                                                                <h1 class="modal-title fs-5 fw-semibold" id="exampleModalLabel"><?= $ads['AdName'] ?></h1>
                                                            </div>
                                                            <div class="item3">
                                                                <span class="text-muted mx-auto"><small><?= $ads['UserName'] . " posted on " . $formattedDatetime ?></small></span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                                        <img class="modal-content" id="modalImg" src="<?= $ads['AdPaymentPicture'] ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="container d-flex text-break p-0 m-0 justify-content-between" id="caption">
                                                            <div class="">Amount to be paid: RM <?= $ads['Price'] ?></div>
                                                            <button class="btn btn-primary " data-bs-target="#modalEdit-<?= $ads['AdID'] ?>" data-bs-toggle="modal">Back to Edit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--//!REJECT Payment MODAL-->
                                        <div class="modal fade p-0" id="rejectPayment-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                                            <div class="modal-dialog modal-md modal-dialog-centered mt-1">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-3 fw-semibold" id="exampleModalToggleLabel2">Reject Ad Payment</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="text-start mb-2 p-0 fs-5"> <span class="fw-semibold">Title:</span><?= $ads['AdName'] ?></div>
                                                        <form action="Includes/authActions.php?request=RejectPayment" method="POST">
                                                            <label for="formFile" class="form-label text-danger">Are you sure you want to <B><u>reject the payment?</u></B></label>
                                                            <div class="container-fluid d-flex justify-content-end">
                                                                <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                                <input type="hidden" value="<?= $redirect ?>" name="redirect">
                                                                <input type="hidden" value="modalEdit-<?= $ads['AdID'] ?>" name="modalID">
                                                                <input type="submit" class="btn btn-outline-danger mx-2 px-4 dynamic-input" value="Yes" id="rejectPaymentButton-<?= $ads['AdID'] ?>">
                                                                <button type="button" class="btn btn-outline-warning px-4" data-bs-target="#modalEdit-<?= $ads['AdID'] ?>" data-bs-toggle="modal">No</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!--//!Accept Payment MODAL-->
                                        <div class="modal fade p-0" id="acceptPayment-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel3" tabindex="-1">
                                            <div class="modal-dialog modal-md modal-dialog-centered mt-1">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-3 fw-semibold" id="exampleModalToggleLabel3">Accept Ad Payment</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="text-start mb-2 p-0 fs-5"> <span class="fw-semibold">Title:</span><?= $ads['AdName'] ?></div>
                                                        <form action="Includes/authActions.php?request=ApproveAd" method="POST">
                                                            <label for="formFile" class="form-label text-primary">Ensure correct amount has been paid first.<br>This ad will be approved and posted!<br>Are you sure you want to <b><u>accept the payment?</u></b></label>
                                                            <div class="container-fluid d-flex justify-content-end">
                                                                <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                                <input type="hidden" value="<?= $redirect ?>" name="redirect">
                                                                <input type="hidden" value="modalEdit-<?= $ads['AdID'] ?>" name="modalID">
                                                                <input type="submit" class="btn btn-outline-primary mx-2 px-4 dynamic-input" value="Yes" id="acceptPaymentButton-<?= $ads['AdID'] ?>">
                                                                <button type="button" class="btn btn-outline-danger px-4" data-bs-target="#modalEdit-<?= $ads['AdID'] ?>" data-bs-toggle="modal">No</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    <?php endif;
                                    if ($ads['AdStatus'] == "Pending Review") :
                                    ?>


                                        <!--//!REJECT Request MODAL-->
                                        <div class="modal fade p-0" id="rejectRequest-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel4" tabindex="-1">
                                            <div class="modal-dialog modal-md modal-dialog-centered mt-1">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-3 fw-semibold" id="exampleModalToggleLabel4">Reject Ad Request</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <div class="text-start mb-2 p-0 fs-5"> <span class="fw-semibold">Title:</span><?= $ads['AdName'] ?></div>
                                                        <form action="Includes/authActions.php?request=RejectRequest" method="POST">
                                                            <label for="formFile" class="form-label text-danger">Are you sure you want to <b><u>reject the request?</u></b></label>
                                                            <div class="container-fluid d-flex justify-content-end">
                                                                <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                                <input type="hidden" value="<?= $redirect ?>" name="redirect">
                                                                <input type="hidden" value="modalEdit-<?= $ads['AdID'] ?>" name="modalID">
                                                                <input type="submit" class="btn btn-outline-danger mx-2 px-4 dynamic-input" value="Yes" id="rejectRequestButton-<?= $ads['AdID'] ?>">
                                                                <button type="button" class="btn btn-outline-warning px-4" data-bs-target="#modalEdit-<?= $ads['AdID'] ?>" data-bs-toggle="modal">No</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>



                                        <!--//!Accept Request MODAL-->
                                        <div class="modal fade p-0" id="acceptRequest-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel5" tabindex="-1">
                                            <div class="modal-dialog modal-md modal-dialog-centered mt-1">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-3 fw-semibold" id="exampleModalToggleLabel5">Accept Ad Request</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="text-start mb-2 p-0 fs-5"> <span class="fw-semibold">Title:</span><?= $ads['AdName'] ?></div>
                                                        <form action="Includes/authActions.php?request=AcceptRequest" method="POST">

                                                            <div class="d-inline-flex  align-items-center">
                                                                <label for="Price">Price: </label>

                                                                <div class="input-group ms-1">
                                                                    <span class="input-group-text">RM</span>
                                                                    <input type="number" step="0.01" class="form-control w-75 p-1 " placeholder="Enter an amount" id="Price" name="Price" min="0" data-bind="value:replyNumber" onkeypress="return (event.charCode != 8) && (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46" required>
                                                                </div>
                                                            </div><br><br>

                                                            <label for="formFile" class="form-label text-primary">Are you sure you want to <b><u>accept the request?</u></b></label>
                                                            <div class="container-fluid d-flex justify-content-end">

                                                                <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                                <input type="hidden" value="<?= $redirect ?>" name="redirect">
                                                                <input type="hidden" value="modalEdit-<?= $ads['AdID'] ?>" name="modalID">
                                                                <input type="submit" class="btn btn-outline-success mx-2 px-4 dynamic-input" value="Yes" id="acceptRequestButton-<?= $ads['AdID'] ?>">
                                                                <button type="button" class="btn btn-outline-danger px-4" data-bs-target="#modalEdit-<?= $ads['AdID'] ?>" data-bs-toggle="modal">No</button>
                                                            </div>

                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    <?php endif; ?>

                                    <!--//!Cancel MODAL-->
                                    <div class="modal fade p-0" id="cancel-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel6" tabindex="-1">
                                        <div class="modal-dialog modal-md modal-dialog-centered mt-1">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-3 fw-semibold" id="exampleModalToggleLabel6">Cancel Ad</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-start mb-2 p-0 fs-5"> <span class="fw-semibold">Title:</span><?= $ads['AdName'] ?></div>
                                                    <form action="Includes/authActions.php?request=CancelAd" method="POST">
                                                        <label for="formFile" class="form-label text-danger">Are you sure you want to <B><u>cancel?</u></B> <br>You can't revert this action!</label>
                                                        <div class="container-fluid d-flex justify-content-end">
                                                            <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                            <input type="hidden" value="<?= $redirect ?>" name="redirect">
                                                            <input type="submit" class="btn btn-outline-danger mx-2 px-4 dynamic-input" value="Yes" id="cancelButton-<?= $ads['AdID'] ?>">
                                                            <button type="button" class="btn btn-outline-warning px-4" data-bs-target="#modalEdit-<?= $ads['AdID'] ?>" data-bs-toggle="modal">No</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <!--//!MODAL FOR EDIT ADS-->

                                    <div class="modal fade p-0" id="edit-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel7" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered mt-1">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-3 fw-semibold" id="exampleModalToggleLabel7 ">Edit Ads</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <form action="Includes/authActions.php?request=EditAd" method="POST">

                                                        <div class="row g-2 mb-3">
                                                            <div class="col-md-4">
                                                                <div class="form-floating mb-2">
                                                                    <input type="text" class="form-control" id="floatingInputDisabled" name="AdID" placeholder="ID" value="<?= $ads['AdID'] ?>" disabled>
                                                                    <label for="floatingInputDisabled">ID</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-floating">
                                                                    <select class="form-select" id="floatingSelectGrid" name="status">
                                                                        <option selected><?= $ads['AdStatus'] ?></option>
                                                                        <option value="Pending Review">Pending Review</option>
                                                                        <option value="Pending Payment">Pending Payment</option>
                                                                        <option value="Checking Payment">Checking Payment</option>
                                                                        <option value="Rejected Request">Rejected Request</option>
                                                                        <option value="Rejected Payment">Rejected Payment</option>
                                                                        <option value="Cancelled">Cancelled</option>
                                                                        <option value="Expired">Expired</option>
                                                                        <option value="Approved">Approved</option>
                                                                    </select>
                                                                    <label for="floatingSelectGrid">Status Options</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <textarea class="form-control" placeholder="Title" name="title" id="floatingTextarea"><?= $ads['AdName'] ?></textarea>
                                                            <label for="floatingTextarea">Title</label>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <textarea class="form-control" placeholder="Description" name="description" id="floatingTextarea"><?= $ads['AdDescription'] ?></textarea>
                                                            <label for="floatingTextarea">Description</label>
                                                        </div>

                                                        <div id="category-select-<?= $ads['AdID'] ?>"></div><br><br>

                                                        <label for="formFile" class="form-label text-danger">Are you sure you want to <b><u>edit the Ad?</u></b></label>
                                                        <div class="container-fluid d-flex justify-content-end">

                                                            <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                            <input type="hidden" value="<?= $redirect ?>" name="redirect">
                                                            <input type="hidden" value="edit-<?= $ads['AdID'] ?>" name="modalID">
                                                            <input type="submit" class="btn btn-outline-primary mx-2 px-4 dynamic-input" value="Yes">
                                                            <button type="button" class="btn btn-outline-danger px-4" data-bs-target="#modalEdit-<?= $ads['AdID'] ?>" data-bs-toggle="modal">No</button>
                                                            <input type="reset" class="btn btn-outline-secondary mx-2 px-4" value="Reset">
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            VirtualSelect.init({
                                                ele: "#category-select-<?= $ads['AdID'] ?>",
                                                options: [
                                                    <?php
                                                    $categoriesData2 = $classified->getCategories();
                                                    $result2 = $categoriesData2['result'];
                                                    while ($categories2 = $result2->fetch_assoc()) {
                                                        $categoryName2 = $categories2["Category"]; ?> {
                                                            label: "<?= $categoryName2 ?>",
                                                            value: "<?= $categoryName2 ?>"
                                                        },
                                                    <?php } ?>
                                                ],
                                                search: true,
                                                required: true,
                                                multiple: true,
                                                allowNewOption: true,
                                                selectedValue: [<?= implode(",", array_map(fn($word) => '"' . trim($word) . '"', explode(",", $ads["AdCategory"])))?>],
                                                noSearchResultsText: "No Categories Found",
                                                searchPlaceholderText: "Seach Categories...",
                                                placeholder: "Select Categories",
                                                name: "categories",
                                            });
                                        });
                                    </script>


                                <?php endif; ?>


                            <?php }
                        else : ?>


                            <span class="h2 text-center text-secondary mt-5">No Advertisement Request or Post was found!</span>
                        <?php endif; ?>



                    </div>
                </div>
            </div>
        </div>

        <!--//!Add Category MODAL-->
        <div class="modal fade p-0" id="addcate" aria-hidden="true" aria-labelledby="addcate" tabindex="-1">
            <div class="modal-dialog modal-md modal-dialog-centered mt-1">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3 fw-semibold" id="addcate">Add Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="Includes/authActions.php?request=addremovecat" method="POST">

                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="add-cat" id="floatingInputGrid" placeholder="Category">
                                        <label for="floatingInputGrid">Add Category</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select class="form-select" name="del-cat" id="floatingSelectGrid">
                                            <option selected>None</option>
                                            <?php
                                            $categoriesData3 = $classified->getCategories();
                                            $result3 = $categoriesData3['result'];

                                        if (mysqli_num_rows($result3) > 0) :
                                            while ($categories3 = $result3->fetch_assoc()) {
                                                $categoryName3 = $categories3["Category"];
                                        ?>
                                        <option value="<?= $categoryName3?>"><?= $categoryName3 ?></option>
                                    <?php } endif;?>
                                    </select>
                                    <label for="floatingSelectGrid">Delete Category</label>
                                </div>
                            </div>
                        </div><br>

                        <label for="formFile" class="form-label text-danger">Are you sure you want to <B><u>add/remove?</u></B></label>
                        <div class="container-fluid d-flex justify-content-end">
                            <input type="hidden" value="<?= $redirect ?>" name="redirect">
                            <input type="submit" class="btn btn-outline-primary mx-2 px-4" value="Add/Delete" id="AddButton" name="add">
                            <button type="button" class="btn btn-outline-danger mx-2 px-3" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

                </div>
            </div>
        </div>
        <!--ADMIN -->

    <?php endif; ?>











    <!--Load more button-->
    <div class="container-fluid m-auto mb-3 text-center">
        <button type="button" class="btn btn-outline-secondary btn-lg w-50 mx-auto focus-ring" style="--bs-focus-ring-color: rgba(var(--bs-secondary-rgb), .25)">Load More...</button>
    </div>
    <!--Load more button-->


    <!--footer-->
    <?php
    include("Includes/footer.php");
    ?>
    <!--footer-->


</body>

</html>