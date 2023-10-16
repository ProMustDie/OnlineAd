<?php include('includes/app.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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

                <form action="#" method="GET">
                    <div class="text-center mt-5">
                        <b class="fs-3">Categories</b>
                        <hr>
                        <div class="text-start">

                            <!--//TODO: Can try to loop this-->
                            <div class="checkbox-wrapper-4 " id="CateText">
                                <input class="inp-cbx" id="morning" type="checkbox" />
                                <label class="cbx" for="morning"><span>
                                        <svg width="12px" height="10px">
                                            <use xlink:href="#check-4"></use>
                                        </svg></span><span>Morning</span></label>
                                <svg class="inline-svg">
                                    <symbol id="check-4" viewbox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </symbol>
                                </svg>
                            </div>

                            <div class="checkbox-wrapper-4" id="CateText">
                                <input class="inp-cbx" id="Afternoon" type="checkbox" />
                                <label class="cbx" for="Afternoon"><span>
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

                        <input type="submit" class="button-31 mt-5" value="Search">

                    </div>
                </form>
            </div>
            <!--//!Category-->


            <!--//!Images-->
            <div class="col-sm-8 col-md-8 col-lg-9 col-xl-10 bg-light">

                <div class="row d-flex m-3 justify-content-center">


                    <div class="card m-3" style="width: 30rem;">
                        <div class="ImgContainer m-3">
                            <img src="img/logo.png" class="imgSize card-img-top img-fluid" alt="..." id="myImg" onclick="openModal('img/logo.png', 'Lorem4000')">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fs-3 fw-bold" id="TextHeader">Card title</h5>
                            <p class="card-text" id="TextSub">This is a wider card with supporting text below as a
                                natural lead-in to
                                additional content. This content is a little bit longer.</p>
                            <p class="card-text" id="TextTime"><small class="text-muted">Last updated 3 mins ago</small>
                            </p>
                        </div>
                    </div>

                    <div class="card m-3" style="width: 30rem;">
                        <div class="ImgContainer m-3">
                            <img src="img/TheSun.jpeg" class="imgSize card-img-top img-fluid" alt="..." id="myImg" onclick="openModal('img/TheSun.jpeg', 'Snow')">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fs-3 fw-bold" id="TextHeader">Card title</h5>
                            <p class="card-text" id="TextSub">This is a wider card with supporting text below as a
                                natural lead-in to
                                additional content. This content is a little bit longer.</p>
                            <p class="card-text" id="TextTime"><small class="text-muted">Last updated 3 mins ago</small>
                            </p>
                        </div>
                    </div>




                    <!--//!Images-->


                </div>

            </div>

        </div>

    </div>

    <!--Main Body-->


    <!--Footer-->

    <footer class="footer bg-dark text-center text-white  mt-5">
        <!-- Grid container -->
        <div class="container p-4 pb-0">
            <!-- Section: Social media -->
            <section class="mb-4">
                <!-- Facebook -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com/thesundaily" role="button"><i class="bi bi-facebook"></i></a>

                <!-- Twitter -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://twitter.com/thesundaily" role="button"><i class="bi bi-twitter-x"></i></a>

                <!-- Google -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://www.instagram.com/thesundaily/" role="button"><i class="bi bi-instagram"></i></a>

                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://www.youtube.com/channel/UCJNLiW1NkgyHeoijxH-a_Wg" role="button"><i class="bi bi-youtube"></i></a>

                <!-- Linkedin -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://www.tiktok.com/@thesundaily?lang=en" role="button"><i class="bi bi-tiktok"></i></a>

                <!-- Github -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://t.me/thesuntelegram" role="button"><i class="bi bi-telegram"></i></a>

            </section>
            <!-- Section: Social media -->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2020 Copyright:
            <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
        </div>
        <!-- Copyright -->
    </footer>

    <!--Footer-->



    <!--//!MODAL FOR IMAGES -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImg">
        <div class="container text-break" id="caption"></div>
    </div>

    <script src="JS/MainModal.js"></script>
</body>

</html>