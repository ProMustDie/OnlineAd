<?php
include('includes/app.php');
include_once('includes/Classified.php');
$classified = new Classified;
include('Includes/AuthController.php');
$redirect = basename($_SERVER['PHP_SELF']);
if (!empty($_SERVER['QUERY_STRING'])) {
    $redirect .= '?' . $_SERVER['QUERY_STRING'];
}
$AuthLogin = new AuthenticatorController($redirect);
$AdminLogin = $AuthLogin->AdminPanel($redirect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Statistics</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</head>



<body class="bg-light">


    <?php
    include("Includes/navbar.php");
    ?>

    <!-- CHART PARAMS -->
    <nav class="navbar navbar-expand-lg bg-dark ">
        <div class="container-fluid">
            <button class="navbar-toggler bg-warning" type="button" id="time" data-bs-toggle="collapse" data-bs-target="#Stats" aria-controls="Stats" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" id="time"></span>
            </button>
            <div class="collapse navbar-collapse" id="Stats">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"><button type="button" class="btn btn-outline-light" onclick="exportLineChartsToPDF()">Export Line
                                Charts
                                to PDF</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"><button type="button" class="btn btn-outline-light" onclick="exportTablesToExcel()">Export Table to
                                Excel</button></a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link text-light fw-semibold fs-5" id="TimeStatus"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"> <button type="button" class="btn btn-outline-light" onclick="changeData('daily')">Daily</button>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"><button type="button" class="btn btn-outline-light" onclick="changeData('weekly')">Weekly</button>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"><button type="button" class="btn btn-outline-light" onclick="changeData('monthly')">Monthly</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- DATA & CHARTS -->
    <div class="container-fluid text-center ">




</body>

</html>