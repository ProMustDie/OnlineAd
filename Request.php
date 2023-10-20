<?php include('includes/app.php'); ?>
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


    <!--Request -->
    <div class="container mt-5 p-5 bg-light ">
        <div class="row ">
            <div class="col ">
                <form action="#" method="#" class="needs-validation " novalidate>



                    <input type="file" class="form-control m-auto mb-2" id="validationCustom01" name="image" style="width:75%;" required>

                    <input type="text" class="form-control m-auto mb-2" id="validationCustom02" placeholder="Title" name="title" required style="width:75%;">

                    <textarea class="form-control  m-auto mb-2" id="validationTextarea01" placeholder="Description" style="width:75%;" rows="2" name="description" required></textarea>


                    <!--//! Need to use php to validate atleast 1 category is chosen -->
                    <div class="container text-start p-0" style="width:75%;">

                        <label>Categories</label>
                        <div class="checkbox-wrapper-4">
                            <input class="inp-cbx" id="morning" type="checkbox" />
                            <label class="cbx m-auto" for="morning"><span>
                                    <svg width="12px" height="10px">
                                        <use xlink:href="#check-4"></use>
                                    </svg></span><span>Morning</span></label>
                            <svg class="inline-svg">
                                <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </symbol>
                            </svg>
                        </div>

                        <div class="checkbox-wrapper-4">
                            <input class="inp-cbx" id="Afternoon" type="checkbox" />
                            <label class="cbx m-auto" for="Afternoon"><span>
                                    <svg width="12px" height="10px">
                                        <use xlink:href="#check-4"></use>
                                    </svg></span><span>Afternoon</span></label>
                            <svg class="inline-svg">
                                <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </symbol>
                            </svg>
                        </div>

                    </div>
                    <!--//! Need to use php to validate atleast 1 category is chosen -->



                    <textarea class="form-control  m-auto mb-2" id="validationTextarea02" placeholder="Additional Info" style="width:75%;" rows="2" name="ExtraInfo" required></textarea>



                    <input type="submit" name="RequestSubmit" value="Request" id="request">

                </form>
            </div>
        </div>
    </div>

    <!--Request -->


    <!--//! ADMIN -->

    <div class="container">

        <!--//!Category-->
        <div class="row">


            <div class="col-sm-4 col-md-3 col-lg-3 col-xl-2">

                <form action="" method="GET">
                    <div class="text-center mt-5">
                        <b class="fs-3">Categories</b>
                        <hr>
                        <div class="text-start">

                            <div class="checkbox-wrapper-4" id="CateText">
                                <input class="inp-cbx" id="Evening" type="checkbox" />
                                <label class="cbx" for="Evening"><span>
                                        <svg width="12px" height="10px">
                                            <use xlink:href="#check-4"></use>
                                        </svg></span><span>Evening</span></label>
                                <svg class="inline-svg">
                                    <symbol id="check-4" viewbox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </symbol>
                                </svg>
                            </div>

                        </div>

                        <b class="fs-3">Status</b>
                        <hr>
                        <div class="text-start">

                            <div class="checkbox-wrapper-4" id="CateText">
                                <input class="inp-cbx" id="Paid" type="checkbox" />
                                <label class="cbx" for="Paid"><span>
                                        <svg width="12px" height="10px">
                                            <use xlink:href="#check-4"></use>
                                        </svg></span><span>Paid</span></label>
                                <svg class="inline-svg">
                                    <symbol id="check-4" viewbox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </symbol>
                                </svg>
                            </div>

                        </div>


                        <input type="hidden" name="search" value="<?= $key ?>">
                        <input type="submit" class="button-31 mt-5" value="Search">

                    </div>
                </form>
            </div>
            <!--//!Category-->

            <div class="col bg-light">

                <div class="row d-flex m-3 justify-content-center">

                    <?php
                    $result = $classified->getAds(NULL, NULL, NULL, isset($_SESSION['auth_user']) ? $_SESSION['auth_user']['user_id'] : NULL); //Pending Review, Rejected Request, Pending Payment, Rejected Payment, Approved, Cancelled, Expired
                    if (mysqli_num_rows($result) > 0) :
                        while ($ads = $result->fetch_assoc()) {
                            $datetime = new DateTime($ads['AdPostedDateTime']);
                            $formattedDatetime = $datetime->format('h:iA d/m/Y');
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

                                            <span class="rounded-3 bg-success text-light px-2 py-1">
                                                <?= $category ?>
                                            </span>


                                        <?php } ?>
                                    </p>

                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            ID: 0<br>
                                            By: Name<br>
                                            Categories:<br>
                                            Additional Info:
                                        </li>
                                        <li class="list-group-item p-0 m-0 border-bottom-0">

                                            <div class="d-flex m-2 ">
                                                <div class="container-fluid p-0 d-inline-flex align-items-center">
                                                    Status:
                                                    <?php switch ($ads['AdStatus']) {
                                                        case "Pending Review":
                                                        case "Pending Payment":
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
                                        <li class="list-group-item p-0 m-0 border-0">
                                            <p class="card-text p-2" id="TextTime"><small class="text-muted">
                                                    <?php if ($ads['AdStatus'] == "Expired" || $ads['AdStatus'] == "Cancelled" || $ads['AdStatus'] == "Approved") : echo "Posted at " . $formattedDatetime;
                                                    else : echo "Requested at " . $formattedDatetime;
                                                    endif; ?>
                                                </small></p>
                                        </li>

                                        <li class="list-group-item p-0 m-0 border-bottom-0">
                                            <div class="container-fluid p-0">
                                                <form action="#" method="#">
                                                    <a href="#" class="btn btn-outline-primary">Accept</a>
                                                    <a href="#" class="btn btn-outline-danger mx-2">Reject</a>
                                                    <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#Receipt-<?= $ads['AdID'] ?>">Check Payment</a>
                                                </form>

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
                                                <?= $ads['AdDescription'] ?>
                                            </div>
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




    <!--footer-->
    <?php
    include("Includes/footer.php");
    ?>
    <!--footer-->



    <script src="JS/request.js"></script>


</body>

</html>