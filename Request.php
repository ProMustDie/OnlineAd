<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        input[type="submit"]#request {
            width: 60%;
            height: 40px;
            margin: 10px auto;
            justify-content: center;
            display: block;
            color: #fff;
            background: #573b8a;
            font-size: 1em;
            font-weight: bold;
            margin-top: 20px;
            outline: none;
            border: none;
            border-radius: 5px;
            transition: .2s ease-in;
            cursor: pointer;
        }
    </style>

    <title>Request</title>
</head>

<body>

    <?php
    include("Includes/navbar.php");
    ?>

    <div class="container mt-5 bg-light">
        <div class="row">
            <div class="col">
                <form action="#" method="#" class="needs-validation" novalidate>

                    <input type="file" class="form-control m-auto mb-2" id="validationCustom01" name="image" style="width:75%;">

                    <input type="text" class="form-control m-auto mb-2" id="validationCustom02" placeholder="Title" name="title" required style="width:75%;">

                    <textarea id="validationCustom02" placeholder="Description" class="form-control m-auto mb-2" name="description" style="width:75%;" rows="5"></textarea>


                    <textarea id="validationCustom03" placeholder="Extra Info" class="form-control m-auto mb-2" name="ExtraInfo" style="width:75%;" rows="2"></textarea>

                    <input type="submit" name="RequestSubmit" value="Request" id="request">

                </form>
            </div>
        </div>
    </div>


    <script src="JS/request.js"></script>

</body>

</html>