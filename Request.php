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

    <div class="container mt-5 p-5 bg-light ">
        <div class="row ">
            <div class="col ">
                <form action="#" method="#" class="needs-validation " novalidate>



                    <input type="file" class="form-control m-auto mb-2" id="validationCustom01" name="image" style="width:75%;">

                    <input type="text" class="form-control m-auto mb-2" id="validationCustom02" placeholder="Title" name="title" required style="width:75%;">

                    <textarea class="form-control is-invalid m-auto mb-2" id="validationTextarea01" placeholder="Description" style="width:75%;" rows="2" name="description" required></textarea>

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

                    <textarea class="form-control is-invalid m-auto mb-2" id="validationTextarea02" placeholder="Additional Info" style="width:75%;" rows="2" name="ExtraInfo" required></textarea>



                    <input type="submit" name="RequestSubmit" value="Request" id="request">

                </form>
            </div>
        </div>
    </div>


    <script src="JS/request.js"></script>

</body>

</html>