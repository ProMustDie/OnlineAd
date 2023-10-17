<?php include('includes/app.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/request.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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



                    <input type="file" class="form-control m-auto mb-2" id="validationCustom01" name="image" style="width:75%;">

                    <input type="text" class="form-control m-auto mb-2" id="validationCustom02" placeholder="Title" name="title" required style="width:75%;">

                    <textarea class="form-control  m-auto mb-2" id="validationTextarea01" placeholder="Description" style="width:75%;" rows="2" name="description" required></textarea>

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

                    <textarea class="form-control  m-auto mb-2" id="validationTextarea02" placeholder="Additional Info" style="width:75%;" rows="2" name="ExtraInfo" required></textarea>



                    <input type="submit" name="RequestSubmit" value="Request" id="request">

                </form>
            </div>
        </div>
    </div>

    <!--Request -->


    <!--//! ADMIN -->

    <div class="col bg-light">

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

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            ID: 0<br>
                            By: Name<br>
                            Categories:<br>
                            Additional Info:
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-end m-2">
                                <form action="#" method="#">
                                    <a href="#" class="btn btn-outline-primary mx-2">Accept</a>
                                    <a href="#" class="btn btn-outline-danger">Reject</a>
                                </form>
                            </div>
                        </li>
                    </ul>


                    <p class="card-text" id="TextTime"><small class="text-muted">Last updated 3 mins ago</small>
                    </p>
                </div>
            </div>




        </div>
    </div>

    <!--ADMIN -->


    <!--//!MODAL FOR IMAGES -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImg">
        <div class="container text-break mt-3" id="caption"></div>
    </div>

    <script src="JS/MainModal.js"></script>
    <script src="JS/request.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>