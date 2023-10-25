<?php include('includes/app.php');
include_once('includes/Classified.php');
$classified = new Classified;
include('Includes/AuthController.php');
$AuthLogin = new AuthenticatorController();
$redirect = basename($_SERVER['PHP_SELF']); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/request.css" rel="stylesheet">
    <title>Request</title>
</head>

<body>

    <?php
    include("Includes/navbar.php");
    ?>

    <?php if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true && $_SESSION['auth_user']['user_type'] != "Admin") : ?>
        <!--Request -->

        <div class="container  p-5 bg-light ">
            <div class="row ">
                <div class="col ">
                    <u style="text-decoration-thickness: 2px; color:gray">
                        <h2 class="text-center text-secondary mb-3">Request Form Submission</h2>
                    </u>
                    <form action="Includes/RequestAds.php" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">


                        <input type="hidden" name="UserID" value="<?= $_SESSION['auth_user']['user_id'] ?>">

                        <input type="file" class="form-control m-auto mb-2" id="validationCustom01" name="fileUpload" style="width:75%;" required accept="image/png, image/jpeg, image/jpg, application/pdf">

                        <input type="text" class="form-control m-auto mb-2" id="validationCustom02" placeholder="Title" name="title" required style="width:75%;">

                        <textarea class="form-control  m-auto mb-2" id="validationTextarea01" placeholder="Description" style="width:75%;" rows="2" name="description" required></textarea>


                        <!--//! Need to use php to validate atleast 1 category is chosen -->
                        <div class="container text-start p-0" style="width:75%;">

                            <label>Categories</label>

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




                        <textarea class="form-control  m-auto mb-2" id="validationTextarea02" placeholder="Additional Info" style="width:75%;" rows="2" name="ExtraInfo" required></textarea>



                        <input type="submit" name="RequestSubmit" value="Request" id="request">

                    </form>
                </div>
            </div>
        </div>

        <!--Request -->

    <?php elseif (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true && $_SESSION['auth_user']['user_type'] == "Admin") : ?>



        <!--//! ADMIN -->

        <div class="container-fluid bg-light">

            <!--//!Category-->
            <div class="row">


                <div class="col col-md-4 col-lg-3 col-xl-2.5 m-0 p-0">

                    <nav class="navbar navbar-expand-md bg-body-tertiary">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span><span style="position:relative; top:2px;">Filter</span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                                <form action="" method="GET">
                                    <div class="text-center mt-1">
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
                                                    <div class="checkbox-wrapper-4 ms-3" id="CateText">
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
                                                    <div class="checkbox-wrapper-4 ms-3" id="CateText">
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


                                        <input type="hidden" name="search" value="<?= $key ?>">
                                        <input type="submit" class="button-31 mt-5 mb-5" value="Search">

                                    </div>
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>
                <!--//!Category-->

                <div class="col bg-light">

                    <div class="row d-flex m-1 justify-content-center">

                        <?php
                        $result = $classified->getAds($key, $filter, $status, NULL);
                        if (mysqli_num_rows($result) > 0) :
                            while ($ads = $result->fetch_assoc()) {
                                $datetime = new DateTime($ads['AdPostedDateTime']);
                                $formattedDatetime = $datetime->format('h:iA d/m/Y');
                        ?>

                                <div class="card m-2" style="width: 24rem;">
                                    <div class="ImgContainer m-2">
                                        <img src="<?= $ads['AdPicture'] ?>" class="imgSize card-img-top img-fluid" id="myImg" data-bs-toggle="modal" data-bs-target="#modalImg-<?= $ads['AdID'] ?>">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title fs-3 fw-bold" id="TextHeader">
                                            <?= $ads['AdName'] ?>
                                        </h5>
                                        <p class="card-text text-truncate" id="TextSub">
                                            <?= $ads['AdDescription'] ?>
                                        </p>
                                        <p class="card-text lh-lg" id="TextCate">Category:
                                            <?php
                                            $categoriesArray = explode(',', $ads['AdCategory']);
                                            foreach ($categoriesArray as $category) {

                                            ?>

                                                <span class="rounded-3 bg-success text-light px-2 py-1"><?= $category ?></span>


                                            <?php } ?>
                                        </p>


                                        <ul class="list-group list-group-flush">

                                            <li class="list-group-item p-0 m-0 ">

                                                <div class="d-flex m-2 ">

                                            <li class="list-group-item p-0 m-0 border-0">
                                                <p class="card-text mb-3" id="TextTime"><small class="text-muted">
                                                        <p class="card-text mb-3" id="TextTime"><small class="text-muted"><?php if ($ads['AdStatus'] == "Expired" || $ads['AdStatus'] == "Cancelled" || $ads['AdStatus'] == "Approved") : echo  $ads['UserName'] . " posted at " . $formattedDatetime;
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


                                            <li class="list-group-item p-0 m-0 border-bottom-0">
                                                <div class="container-fluid p-0">
                                                    <?php if ($ads['AdStatus'] == "Pending Review") : ?>
                                                        <button class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#acceptReview-<?= $ads['AdID'] ?>">Accept Review</button>
                                                        <button class="btn btn-outline-danger mb-2" data-bs-toggle="modal" data-bs-target="#rejectReview-<?= $ads['AdID'] ?>">Reject Review</button>
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
                                                    <?php endif; ?>
                                                </div>





                                    </div>
                                    </li>

                                    </ul>
                                </div>



                                <!--//!MODAL FOR IMAGES POPUP-->

                                <div class="modal fade p-0" id="modalImg-<?= $ads['AdID'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content modal-xl">
                                            <div class="modal-header p-3">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                    <?= $ads['AdName'] ?>
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                                <img class="modal-content" id="modalImg" src="<?= $ads['AdPicture'] ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <div class="container text-center text-break m-auto" id="caption">
                                                    <?= $ads['AdDescription'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!--//!MODAL FOR RECEIPT PAYMENT POPUP-->

                                <div class="modal fade p-0" id="Receipt-<?= $ads['AdID'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content modal-xl">
                                            <div class="modal-header p-3">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                    <?= $ads['AdName'] ?>
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                                <img class="modal-content" id="modalImg" src="<?= $ads['AdPicture'] ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <div class="container text-center text-break m-auto" id="caption">
                                                    Amount to be paid: RM <?= $ads['Price'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!--//!REJECT Request MODAL-->
                                <div class="modal fade" id="rejectReview-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel5" tabindex="-1">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalToggleLabel5">Reject Ad Request</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                Reject: <?= $ads['AdName'] ?>
                                                <form action="Includes/authActions.php?request=deleteAd" method="POST">
                                                    <label for="formFile" class="form-label">Are you sure you want to reject?</label>
                                                    <div class="container-fluid d-flex justify-content-end">
                                                        <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                        <input type="submit" class="btn btn-outline-danger mx-2 px-4" value="Yes">
                                                        <button type="button" class="btn btn-outline-warning px-4" data-bs-dismiss="modal" aria-label="Close">No</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--//!REJECT Payment MODAL-->
                                <div class="modal fade" id="rejectPayment-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel5" tabindex="-1">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalToggleLabel5">Reject Ad Payment</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                Reject: <?= $ads['AdName'] ?>
                                                <form action="Includes/authActions.php?request=deleteAd" method="POST">
                                                    <label for="formFile" class="form-label">Are you sure you want to reject?</label>
                                                    <div class="container-fluid d-flex justify-content-end">
                                                        <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                        <input type="submit" class="btn btn-outline-danger mx-2 px-4" value="Yes">
                                                        <button type="button" class="btn btn-outline-warning px-4" data-bs-dismiss="modal" aria-label="Close">No</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!--//!Accept Request MODAL-->
                                <div class="modal fade" id="acceptReview-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel5" tabindex="-1">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalToggleLabel5">Accept Ad Request</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                Accept: <?= $ads['AdName'] ?>
                                                <form action="Includes/authActions.php?request=deleteAd" method="POST">
                                                    <label for="formFile" class="form-label">Are you sure you want to Accept?</label>
                                                    <div class="container-fluid d-flex justify-content-end">
                                                        <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                        <input type="submit" class="btn btn-outline-success mx-2 px-4" value="Yes">
                                                        <button type="button" class="btn btn-outline-danger px-4" data-bs-dismiss="modal" aria-label="Close">No</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--//!Accept Payment MODAL-->
                                <div class="modal fade" id="acceptPayment-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel5" tabindex="-1">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalToggleLabel5">Accept Ad Payment</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                Accept: <?= $ads['AdName'] ?>
                                                <form action="Includes/authActions.php?request=deleteAd" method="POST">
                                                    <label for="formFile" class="form-label">Are you sure you want to Accept?</label>
                                                    <div class="container-fluid d-flex justify-content-end">
                                                        <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                        <input type="submit" class="btn btn-outline-success mx-2 px-4" value="Yes">
                                                        <button type="button" class="btn btn-outline-danger px-4" data-bs-dismiss="modal" aria-label="Close">No</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--//!Cancel MODAL-->
                                <div class="modal fade" id="cancel-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel5" tabindex="-1">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalToggleLabel5">Cancel Ad</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Cancel: <?= $ads['AdName'] ?>
                                                <form action="Includes/authActions.php?request=CancelAd&redirect=<?= $redirect ?>" method="POST">
                                                    <label for="formFile" class="form-label">Are you sure you want to cancel? <br>You can't revert this action!</label>
                                                    <div class="container-fluid d-flex justify-content-end">
                                                        <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                        <input type="hidden" value="<?= $ads['AdAuthorID'] ?>" name="AdAuthorID">
                                                        <input type="submit" class="btn btn-outline-danger mx-2 px-4" value="Yes">
                                                        <button type="button" class="btn btn-outline-warning px-4" data-bs-dismiss="modal" aria-label="Close">No</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                        <?php }
                        endif; ?>
                    </div>


                </div>
            </div>
        </div>
        </div>

        <!--ADMIN -->

    <?php endif; ?>




    <!--footer-->
    <?php
    include("Includes/footer.php");
    ?>
    <!--footer-->

    <script src="JS/request.js"></script>




</body>

</html>