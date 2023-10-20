<?php
include('includes/app.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div class="row d-flex justify-content-center">
            <?php
            $result = $classified->getAds(NULL, NULL, NULL, isset($_SESSION['auth_user']) ? $_SESSION['auth_user']['user_id'] : NULL); //Pending Review, Rejected Request, Pending Payment, Rejected Payment, Approved, Cancelled, Expired
            if (mysqli_num_rows($result) > 0) :
                while ($ads = $result->fetch_assoc()) {
            ?>

                    <div class="card m-3" style="width: 24rem;">
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
                                $categoriesArray = explode(' ', $ads['AdCategory']);
                                foreach ($categoriesArray as $category) {

                                ?>

                                    <span class="rounded-3 bg-success text-light px-2 py-1"><?= $category ?></span>


                                <?php } ?>
                            </p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"></li>
                                <li class="list-group-item p-0">

                                    <div class="d-flex  m-2">
                                        <div class="container-fluid p-0 d-inline-flex">
                                            Status:
                                            <?php switch ($ads['AdStatus']) {
                                                case "Pending Review":
                                                case "Pending Payment":
                                                    echo '<p class="text-warning">';
                                                    break;
                                                case "Rejected Request":
                                                case "Rejected Payment":
                                                case "Cancelled":
                                                case "Expired":
                                                    echo '<p class="text-danger">';
                                                    break;
                                                case "Approved":
                                                    echo '<p class="text-success">';
                                                    break;
                                            }
                                            echo $ads['AdStatus'];
                                            ?>
                                            </p>
                                        </div>
                                        <div class="container text-end">
                                            <?php if (($ads['AdStatus'] == "Pending Payment" || $ads['AdStatus'] == "Rejected Payment") && $ads['AdStatus'] != "Approved" && $ads['AdStatus'] != "Cancelled") : ?>
                                                <button class="btn btn-outline-success m-1" data-bs-target="#payment-<?= $ads['AdID'] ?>" data-bs-toggle="modal" aria-labelledby="exampleModalToggleLabel2">
                                                    <?php echo ($ads['AdStatus'] == "Pending Payment") ? "Payment" : "Resubmit"; ?>
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($ads['AdStatus'] != "Expired" && $ads['AdStatus'] != "Rejected Request" && $ads['AdStatus'] != "Cancelled") : ?>
                                                <button class="btn btn-outline-danger m-1" data-bs-target="#cancel-<?= $ads['AdID'] ?>" data-bs-toggle="modal">Cancel Ad</button>
                                            <?php endif; ?>
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


    <?php
    $result = $classified->getAds(NULL, NULL, NULL, isset($_SESSION['auth_user']) ? $_SESSION['auth_user']['user_id'] : NULL); //Pending Review, Rejected Request, Pending Payment, Rejected Payment, Approved, Cancelled, Expired
    if (mysqli_num_rows($result) > 0) :
        while ($ads = $result->fetch_assoc()) {
    ?>

            <?php if (($ads['AdStatus'] == "Pending Payment" || $ads['AdStatus'] == "Rejected Payment") && $ads['AdStatus'] != "Approved" && $ads['AdStatus'] != "Cancelled") : ?>
                <!--*PAYMENT MODAL-->
                <div class="modal fade" id="payment-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="payment-<?= $ads['AdID'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="payment-<?= $ads['AdID'] ?>">
                                    <?php echo ($ads['AdStatus'] == "Pending Payment") ? "Payment" : "Resubmit Payment"; ?>
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="CloseModalPayment"></button>
                            </div>
                            <div class="modal-body">

                                Pay for:
                                <?= $ads['AdName'] ?>
                                <form action="#" method="#">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload Image</label>
                                        <input class="form-control" type="file" id="formFile">
                                    </div>
                                    <input type="submit" class="btn btn-outline-success float-end" value="Submit">
                                </form>


                            </div>

                        </div>
                    </div>
                </div>
                <!--*PAYMENT MODAL-->

            <?php endif; ?>

            <?php if ($ads['AdStatus'] != "Expired" && $ads['AdStatus'] != "Rejected Request" && $ads['AdStatus'] != "Cancelled") : ?>
                <!--*CANCEL MODAL-->
                <div class="modal fade" id="cancel-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Cancel Ad</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="CloseModalCancel"></button>
                            </div>
                            <div class="modal-body">

                                Cancel:
                                <?= $ads['AdName'] ?>
                                <form action="Includes/authActions.php?request=CancelAd" method="POST">
                                    <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                    <input type="hidden" value="<?= $ads['AdAuthorID'] ?>" name="AdAuthorID">
                                    <label for="formFile" class="form-label">Are you sure you want to cancel? <br>No refunds will be
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

</body>

</html>