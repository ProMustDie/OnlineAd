<?php include('includes/app.php');
include_once('includes/Classified.php');
$classified = new Classified;
$redirect = basename($_SERVER['PHP_SELF']);

if (!empty($_SERVER['QUERY_STRING'])) {
    $redirect .= '?' . $_SERVER['QUERY_STRING'];
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/main.css" rel="stylesheet">
    <title>Classified</title>
</head>

<body class="bg-light">
    <!--navbar-->
    <?php
    include("Includes/navbar.php");
    ?>
    <!--navbar-->

    <!--Main Body-->



    <div class="container-fluid bg-light p-0">

        <!--//!Category-->
        <div class="row m-0 p-0">


            <div class="col-sm-3 col-md-4 col-lg-2 m-0 p-0">

                <nav class="navbar navbar-expand-sm bg-body-tertiary">
                    <div class="container-fluid">
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
                                    <?php if (!empty($_GET['search'])) { ?>
                                        <input type="hidden" name="search" value="<?= $key ?>">
                                    <?php } ?>
                                    <input type="submit" class="button-31 mt-5 mb-5" value="Search">

                                </div>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>



            <!--//!Category-->





            <!--//!Images-->

            <div class="col col-md-8 col-lg-10 bg-light">

                <div class="row d-flex m-2 justify-content-center">
                    <?php
                    $result = $classified->getAds($key, $filter, array("Approved"), NULL);
                    if (mysqli_num_rows($result) > 0) :
                        while ($ads = $result->fetch_assoc()) {
                            $datetime = new DateTime($ads['AdPostedDateTime']);
                            $formattedDatetime = $datetime->format('h:iA d/m/Y');
                    ?>

                            <div class="card m-2" style="width: 18rem;">
                                <div class="ImgContainer m-2">
                                    <img src="<?= $ads['AdPicture'] ?>" class="imgSize card-img-top" id="myImg" data-bs-toggle="modal" data-bs-target="#modalImg-<?= $ads['AdID'] ?>">
                                </div>
                                <?php if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['user_type'] === "Admin") : ?>
                                    <div class="card-body" style="height:13rem;">
                                    <?php else : ?>
                                        <div class="card-body" style="height:10rem;">
                                        <?php endif; ?>
                                        <div class="title d-inline-flex" style="height:3.5rem; width:15rem; overflow: hidden;">
                                            <h6 class="card-title fw-bold" id="TextHeader" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $ads['AdName'] ?>"><?= $ads['AdName'] ?></h6>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"></li>
                                            <p class="card-text mb-1" id="TextTime"><small class="text-muted">
                                                    <p class="card-text p-0 m-0" id="TextTime"><small class="text-muted"><?= $ads['UserName'] . " posted on " . $formattedDatetime ?></small></p>
                                                </small>
                                                <?php
                                                if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['user_type'] === "Admin") :

                                                ?>
                                            <div class="d-flex justify-content-end m-2">
                                                <button class="btn btn-outline-danger" data-bs-target="#DeleteModal-<?= $ads['AdID'] ?>" data-bs-toggle="modal">Cancel Ad</button>
                                            </div>
                                            </p>


                                            <!--//!DELETE MODAL-->
                                            <div class="modal fade p-0" id="DeleteModal-<?= $ads['AdID'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel5" tabindex="-1">
                                                <div class="modal-dialog modal-md modal-dialog-centered mt-1">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-3" id="exampleModalToggleLabel5"><strong>Cancel Ad</strong></h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <strong class="fs-5">Title: <?= $ads['AdName'] ?></strong><br><br>

                                                            <form action="Includes/authActions.php?request=CancelAd&redirect" method="POST">
                                                                <label for="formFile" class="form-label text-danger">Are you sure you want to <b><u>cancel?</u></b> <br>You can't revert this action!</label>
                                                                <div class="container-fluid d-flex justify-content-end">
                                                                    <input type="hidden" value="<?= $ads['AdID'] ?>" name="AdID">
                                                                    <input type="hidden" value="<?= $redirect ?>" name="redirect">
                                                                    <input type="submit" class="btn btn-outline-danger mx-2 px-4 dynamic-input" value="Yes" id="DeleteButton-<?= $ads['AdID'] ?>">
                                                                    <button type="button" class="btn btn-outline-warning px-4" data-bs-dismiss="modal" aria-label="Close">No</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--//!DELETE MODAL-->

                                        <?php endif; ?>
                                        </ul>
                                        </div>
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


                                <?php }
                        else :
                                ?>
                                <span class="h2 text-center text-secondary mt-5">No Advertisement Request or Post was found!</span>

                            <?php endif; ?>



                            <!--//!Images-->


                            </div>

                </div>

            </div>

            <!--Load more button-->
            <div class="container-fluid pb-3 text-center d-grid gap-2 col-2">
                <button type="button" class="btn btn-outline-secondary btn-lg">Load More...</button>
            </div>
            <!--Load more button-->

        </div>
    </div>

    <!--Main Body-->

    <!--footer-->
    <?php
    include("Includes/footer.php");
    ?>
    <!--footer-->


</body>

</html>