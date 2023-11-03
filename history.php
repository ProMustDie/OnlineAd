<?php
include('includes/app.php');
include_once('includes/Classified.php');
$classified = new Classified;
include('includes/AuthController.php');
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
    <link href="CSS/history.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>

    <!--navbar-->
    <?php
    include("Includes/navbar.php");
    ?>
    <!--navbar-->

    <!--//!HISTORY MODAL-->
    <div class="col bg-light">
        <div class="row d-flex justify-content-center m-0">
            <u style="text-decoration-thickness: 2px; color:gray">
                <h2 class="text-center text-secondary mt-3 text-underline mb-0">History</h2>
            </u>
            <?php
            $result = $classified->getAds($key, NULL, NULL, isset($_SESSION['auth_user']) ? $_SESSION['auth_user']['user_id'] : NULL); //Pending Review, Rejected Request, Checking Payment, Pending Payment, Rejected Payment, Approved, Cancelled, Expired
            if (mysqli_num_rows($result) > 0) :
                while ($ads = $result->fetch_assoc()) {
                    $datetime = new DateTime($ads['AdPostedDateTime']);
                    $formattedDatetime = $datetime->format('h:iA d/m/Y');
            ?>

                    <div class="card m-3" style="width: 18rem;">
                        <div class="ImgContainer m-2">
                            <img src="<?= $ads['AdPicture'] ?>" class="imgSize card-img-top" id="myImg" data-bs-toggle="modal" data-bs-target="#modalImg-<?= $ads['AdID'] ?>">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fs-5 fw-bold text-truncate" id="TextHeader" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="<?= $ads['AdName'] ?>"><?= $ads['AdName'] ?></h5>

                            <p class="card-text text-secondary text-truncate" id="TextSub" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="<?= $ads['AdDescription'] ?>">
                                <small> <?= $ads['AdDescription'] ?></small>
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
                                <li class="list-group-item"></li>
                                <li class="list-group-item p-0 m-0 border-bottom-0">

                                    <div class="d-flex m-2 ">

                                <li class="list-group-item p-0 m-0 border-0">

                                    <p class="card-text mb-1" id="TextTime"><small class="text-muted">
                                            <p class="card-text" id="TextTime"><small class="text-muted"><?php if ($ads['AdStatus'] == "Expired" || $ads['AdStatus'] == "Cancelled" || $ads['AdStatus'] == "Approved") : echo "Posted at " . $formattedDatetime;
                                                                                                            else : echo "Requested at " . $formattedDatetime;
                                                                                                            endif; ?></small></p>
                                        </small></p>
                                </li>


                                <div class="container-fluid p-0 d-inline-flex align-items-center mb-2">
                                    Status: &nbsp;
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
                                    echo $ads['AdStatus'];
                                    ?>
                                    </span>
                                </div>

                                <li class="list-group-item p-0 m-0 border-bottom-0 text-end">
                                    <div class="container-fluid p-0">
                                        <?php if (($ads['AdStatus'] == "Pending Payment" || $ads['AdStatus'] == "Rejected Payment") && $ads['AdStatus'] != "Approved" && $ads['AdStatus'] != "Cancelled") : ?>
                                            <button class="btn btn-outline-success m-1" data-bs-target="#payment-<?= $ads['AdID'] ?>" data-bs-toggle="modal" aria-labelledby="exampleModalToggleLabel2">
                                                <?php echo ($ads['AdStatus'] == "Pending Payment") ? "Payment" : "Resubmit"; ?>
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($ads['AdStatus'] != "Expired" && $ads['AdStatus'] != "Rejected Request" && $ads['AdStatus'] != "Cancelled") : ?>
                                            <button class="btn btn-outline-danger m-0" data-bs-target="#cancel-<?= $ads['AdID'] ?>" data-bs-toggle="modal">Cancel Ad</button>
                                        <?php endif; ?>
                                    </div>




                        </div>
                        </li>

                        </ul>
                    </div>



                    <!--//!MODAL FOR IMAGES POPUP-->

                    <div class="modal fade p-0" id="modalImg-<?= $ads['AdID'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl mt-1">
                            <div class="modal-content modal-xl">
                                <div class="modal-header p-3">

                                    <div class="col">
                                        <div class="item1">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin-left: 95%;"></button>
                                        </div>
                                        <div class="item2">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $ads['AdName'] ?></h1>
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



                <?php }
            else : ?>


                <span class="h2 text-center text-secondary mt-5">No Advertisement Request or Post was found!</span>


            <?php endif; ?>
        </div>
    </div>


    <?php
    $result = $classified->getAds(NULL, NULL, NULL, isset($_SESSION['auth_user']) ? $_SESSION['auth_user']['user_id'] : NULL); //Pending Review, Rejected Request, Checking Payment, Pending Payment, Rejected Payment, Approved, Cancelled, Expired
    if (mysqli_num_rows($result) > 0) :
        while ($ads = $result->fetch_assoc()) {
    ?>

            <?php if (($ads['AdStatus'] == "Pending Payment" || $ads['AdStatus'] == "Rejected Payment") && $ads['AdStatus'] != "Approved" && $ads['AdStatus'] != "Cancelled") : ?>
                <!--//*PAYMENT MODAL-->
                <div class="modal fade p-0" id="payment-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="payment-<?= $ads['AdID'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-md modal-dialog-centered mt-1">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="payment-<?= $ads['AdID'] ?>">
                                    <strong><?php echo ($ads['AdStatus'] == "Pending Payment") ? "Payment" : "Resubmit Payment"; ?></strong>
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="CloseModalPayment"></button>
                            </div>
                            <div class="modal-body">
                                <strong class="fs-5">Title: <?= $ads['AdName'] ?></strong><br>


                                <div class="d-inline-flex  align-items-center">
                                    <strong class="fs-5"><label for="Price">Price: </label></strong>

                                    <div class="input-group ms-1">
                                        <span class="input-group-text">RM</span>
                                        <input type="number" step="0.01" class="form-control w-75 p-1" placeholder="Enter an amount" value="<?= $ads['Price'] ?>" id="Price" name="Price" min="0" data-bind="value:replyNumber" onkeypress="return (event.charCode != 8) && (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46" disabled>
                                    </div>
                                </div><br><br>

                                <form action="includes/RequestAds.php?request=payment" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload Payment Receipt: </label>
                                        <input type="hidden" name="AdID" value="<?= $ads["AdID"] ?>">
                                        <input type="hidden" name="redirect" value="<?= $redirect ?>">
                                        <input type="file" class="form-control m-auto mb-2" id="formFile" name="fileUpload" required accept="image/png, image/jpeg, image/jpg, application/pdf">
                                    </div>
                                    <input type="submit" class="btn btn-outline-success float-end" value="Submit">
                                </form>


                            </div>

                        </div>
                    </div>
                </div>
                <!--//*PAYMENT MODAL-->

            <?php endif; ?>

            <?php if ($ads['AdStatus'] != "Expired" && $ads['AdStatus'] != "Rejected Request" && $ads['AdStatus'] != "Cancelled") : ?>
                <!--//*CANCEL MODAL-->
                <div class="modal fade p-0" id="cancel-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                    <div class="modal-dialog modal-md modal-dialog-centered mt-1">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-3" id="exampleModalToggleLabel2"><strong>Cancel Ad</strong></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="CloseModalCancel"></button>
                            </div>
                            <div class="modal-body">

                                <strong class="fs-5">Title: <?= $ads['AdName'] ?></strong><br><br>
                                <form action="Includes/authActions.php?request=CancelAd&redirect" method="POST">
                                    <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                    <input type="hidden" value="<?= $ads['AdAuthorID'] ?>" name="AdAuthorID">
                                    <input type="hidden" value="<?= $redirect ?>" name="redirect">
                                    <label for="formFile" class="form-label text-danger">Are you sure you want to <b><u>cancel?</u></b> <br>No refunds will be
                                        provided!</label>
                                    <hr>
                                    <div class="container-fluid d-flex justify-content-end">
                                        <input type="submit" class="btn btn-outline-danger mx-2 px-4" value="Yes">
                                        <button type="button" class="btn btn-outline-warning px-4" data-bs-target="#historyModal" data-bs-toggle="modal">No</button>
                                    </div>
                                </form>


                            </div>

                        </div>
                    </div>
                </div>
                <!--*CANCEL MODAL-->
            <?php endif; ?>


    <?php }
    endif; ?>

    <!--//!HISTORY MODAL-->

    <!--footer-->
    <?php
    include("Includes/footer.php");
    ?>
    <!--footer-->
    <script src="JS/request.js"></script>
</body>

</html>