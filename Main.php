<?php include('includes/app.php');
include_once('includes/Classified.php');
$classified = new Classified;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="CSS/main.css" rel="stylesheet">




</head>

<body>

    <!--navbar-->
    <?php
    include("Includes/navbar.php");
    ?>
    <!--navbar-->

    <!--Main Body-->



    <div class="container">

        <!--//!Category-->
        <div class="row">


            <div class="col-sm-4 col-md-3 col-lg-3 col-xl-2">

                <form action="" method="GET">
                    <div class="text-center mt-5">
                        <b class="fs-3">Categories</b>
                        <hr>
                        <div class="text-start">

                        <?php
                        $result = $classified->getCategories();
                        if(mysqli_num_rows($result) > 0):
                        while ($categories = $result->fetch_assoc()) {
                        ?>
                            <div class="checkbox-wrapper-4 " id="CateText">
                                <input class="inp-cbx" id="<?=$categories["Category"]?>" type="checkbox" name="category[]" value="<?=$categories["Category"]?>" />
                                <label class="cbx" for="<?=$categories["Category"]?>"><span>
                                        <svg width="12px" height="10px">
                                            <use xlink:href="#check-4"></use>
                                        </svg></span><span><?=$categories["Category"]?></span></label>
                                <svg class="inline-svg">
                                    <symbol id="check-4" viewbox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </symbol>
                                </svg>
                            </div>
                        <?php }endif; ?>

                        </div>
                        <input type="hidden" name="search" value="<?=$key?>">
                        <input type="submit" class="button-31 mt-5" value="Search">

                    </div>
                </form>
            </div>
            <!--//!Category-->


            <!--//!Images-->
            <div class="col-sm-8 col-md-8 col-lg-9 col-xl-10 bg-light">

                <div class="row d-flex m-3 justify-content-center">
                <?php
                    $result = $classified->getAds($key, $filter);
                    if(mysqli_num_rows($result) > 0):
                    while ($ads = $result->fetch_assoc()) {
                        $datetime = new DateTime($ads['AdPostedDateTime']);
                        $formattedDatetime = $datetime->format('h:iA d/m/Y');
                ?>

                    <div class="card m-3" style="width: 30rem;">
                        <div class="ImgContainer m-2">
                            <img src="<?= $ads['AdPicture']?>" class="imgSize card-img-top img-fluid" id="myImg" onclick="openModal('<?= $ads['AdPicture']?>', '<?= $ads['AdDescription']?>')">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fs-3 fw-bold" id="TextHeader"><?= $ads['AdName']?></h5>
                            <p class="card-text" id="TextSub"><?= $ads['AdDescription']?></p>


                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"></li>
                                    <p class="card-text" id="TextTime"><small class="text-muted"><?= $ads['UserName']." posted at ".$formattedDatetime ?></small></p>    
                                <?php
                                if(isset($_SESSION['auth_user']) && $_SESSION['auth_user']['user_type'] === "Admin"):
                                // ### CHANGE BELOW THE PHP FOR THE DELETE BUTTON TO MODAL BUTTON ###
                                ?>
                                    <div class="d-flex justify-content-end m-2">
                                        <a href="#" class="btn btn-outline-danger">Delete</a>
                                    </div>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>

                <?php }endif; ?>    



                    <!--//!Images-->


                </div>

            </div>

        </div>

    </div>

    <!--Main Body-->

    <!--footer-->
    <?php
    include("Includes/footer.php");
    ?>
    <!--footer-->

    <!--//!MODAL FOR IMAGES -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImg">
        <div class="container text-break mt-3" id="caption"></div>
    </div>

    <script src="JS/MainModal.js"></script>
</body>

</html>