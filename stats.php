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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

</head>



<body class="bg-light">


    <?php
    include("Includes/navbar.php");
    ?>

    <!-- CHART PARAMS -->



    <nav class="navbar navbar-expand-lg bg-dark ">
        <div class="container-fluid">
            <button class="navbar-toggler bg-warning" type="button" id="time" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" id="time"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
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


        <!-- 2 Line Graphs-->
        <div class="row m-1 mb-3 gy-2 gx-2 d-flex">
            <div class="col-lg-6">
                <canvas id="UserReq"></canvas>
            </div>

            <div class="col-lg-6">
                <canvas id="AcceptRej"></canvas>
            </div>
        </div>

        <!-- Data Tables -->
        <div class="row mt-3">

            <!-- Data table-->
            <div class="row  mb-3 gy-2 gx-2 d-flex">
                <div class="col-lg-6 bg-light">
                    <div class="table-responsive" style="height: 26rem;">
                        <table class="table caption-top table-striped table-hover table-bordered border-secondary table-sm" id="UserTable">
                            <caption class="text-dark">Recent Ads Requested (31 Days)</caption>
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">AdName</th>
                                    <th scope="col">AdCategory</th>
                                    <th scope="col">AdPrice</th>
                                    <th scope="col">AdStatus</th>
                                    <th scope="col">Request Date</th>
                                    <th scope="col">Approved Date</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                $result = $classified->getAds31days();
                                if (mysqli_num_rows($result) > 0) :
                                    $counter = 1;
                                    while ($ads = $result->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <th scope="row"><?= $counter ?></th>
                                            <td><?= $ads['UserName'] ?></td>
                                            <td><?= $ads['AdName'] ?></td>
                                            <td><?= $ads['AdCategory'] ?></td>
                                            <td><?= (empty($ads['Price'])) ? "Not Set" : $ads['Price']; ?></td>
                                            <td><?= $ads['AdStatus'] ?></td>
                                            <td><?= $ads['AdRequestedDate'] ?></td>
                                            <td><?= (empty($ads['AdApprovedDate'])) ? "Not Yet Approved" : $ads['AdApprovedDate']; ?></td>
                                        </tr>

                                <?php $counter++;
                                    }
                                endif;
                                ?>


                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row m-0">
                        <div class="col-lg-7" style="height: 26rem;">
                            <canvas id="Sales"></canvas>
                        </div>
                        <div class="col-lg-5">
                            <div class="table-responsive" style="height: 26rem;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                    <div class="container d-none">
                        <?php
                            $totalUsersDay = $classified->getTotalUsers("day");
                            $totalAdsDay = $classified->getTotalReqAds("day");
                            $totalCategoryDay = $totalCategory = $classified->getAdsCategoriesType(7);
                            $totalUsersWeek = $classified->getTotalUsers("week");
                            $totalAdsWeek = $classified->getTotalReqAds("week");
                            $totalCategoryWeek = $totalCategory = $classified->getAdsCategoriesType(31);
                            $totalUsersMonth = $classified->getTotalUsers("month");
                            $totalAdsMonth = $classified->getTotalReqAds("month");
                            $totalCategoryMonth = $totalCategory = $classified->getAdsCategoriesType(365);
                            if (mysqli_num_rows($totalUsersDay) > 0 && mysqli_num_rows($totalAdsDay) && mysqli_num_rows($totalUsersWeek) && mysqli_num_rows($totalAdsWeek) && mysqli_num_rows($totalUsersMonth) && mysqli_num_rows($totalAdsMonth)) :
                                $totalUsersDayArr = [];
                                $totalAdsDayArr = [];
                                $totalUsersWeekArr = [];
                                $totalAdsWeekArr = [];
                                $totalUsersMonthArr = [];
                                $totalAdsMonthArr = [];
                                $totalCategoryDayArr = [];
                                $totalCategoryWeekArr = [];
                                $totalCategoryMonthArr = [];    
                                while ($row = $totalUsersDay->fetch_assoc()) {
                                    $totalUsersDayArr[] = $row;
                                }
                                while ($row = $totalAdsDay->fetch_assoc()) {
                                    $totalAdsDayArr[] = $row;
                                }
                                while ($row = $totalUsersWeek->fetch_assoc()) {
                                    $totalUsersWeekArr[] = $row;
                                }
                                while ($row = $totalAdsWeek->fetch_assoc()) {
                                    $totalAdsWeekArr[] = $row;
                                }
                                while ($row = $totalUsersMonth->fetch_assoc()) {
                                    $totalUsersMonthArr[] = $row;
                                }
                                while ($row = $totalAdsMonth->fetch_assoc()) {
                                    $totalAdsMonthArr[] = $row;
                                }
                                while ($row = $totalCategoryDay->fetch_assoc()) {
                                    $totalCategoryDayArr[] = $row;
                                }
                                while ($row = $totalCategoryWeek->fetch_assoc()) {
                                    $totalCategoryWeekArr[] = $row;
                                }
                                while ($row = $totalCategoryMonth->fetch_assoc()) {
                                    $totalCategoryMonthArr[] = $row;
                                }
                            endif;
                    ?>

                <!--Daily User/Request chart-->
                <div class="container">
                    <table id="AllLineChart">
                        <tr>
                            <th>Daily: </th>
                            <?php
                            foreach ($totalUsersDayArr as $dayArray) {
                                echo "<th>" . $dayArray['Registration_Date'] . "</th>";
                            }
                            echo  "<th>Weekly: </th>";

                            foreach ($totalUsersWeekArr as $weekArray) {
                                echo "<th>" . $weekArray['Week_Start_Date'] . "</th>";
                            }
                            echo  "<th>Monthly: </th>";
                            foreach ($totalUsersMonthArr as $monthArray) {
                                echo "<th>" . $monthArray['Month_Start_Date'] . "</th>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>New User</td>
                            <?php
                            foreach ($totalUsersDayArr as $NewUsers) {
                                echo "<th>" . $NewUsers['Total_Users_Registered'] . "</th>";
                            }
                            echo  "<th>#</th>";

                            foreach ($totalUsersWeekArr as $NewUsers) {
                                echo "<th>" . $NewUsers['Total_Users_Registered'] . "</th>";
                            }
                            echo  "<th>#</th>";
                            foreach ($totalUsersMonthArr as $NewUsers) {
                                echo "<th>" . $NewUsers['Total_Users_Registered'] . "</th>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Requested Ads</td>
                            <?php
                            foreach ($totalAdsDayArr as $ads) {
                                echo "<th>" . $ads['Total_Ads_Requested'] . "</th>";
                            }
                            echo  "<th>#</th>";

                            foreach ($totalAdsWeekArr as $ads) {
                                echo "<th>" . $ads['Total_Ads_Requested'] . "</th>";
                            }
                            echo  "<th>#</th>";
                            foreach ($totalAdsMonthArr as $ads) {
                                echo "<th>" . $ads['Total_Ads_Requested'] . "</th>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <th>#</th>
                        </tr>
                        <tr>
                            <td>Approved</td>
                            <?php
                            foreach ($totalAdsDayArr as $ads) {
                                echo "<th>" . $ads['Total_Ads_Approved'] . "</th>";
                            }
                            echo  "<th>#</th>";

                            foreach ($totalAdsWeekArr as $ads) {
                                echo "<th>" . $ads['Total_Ads_Approved'] . "</th>";
                            }
                            echo  "<th>#</th>";
                            foreach ($totalAdsMonthArr as $ads) {
                                echo "<th>" . $ads['Total_Ads_Approved'] . "</th>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Rejected</td>
                            <?php
                            foreach ($totalAdsDayArr as $ads) {
                                echo "<th>" . $ads['Total_Ads_Rejected'] . "</th>";
                            }
                            echo  "<th>#</th>";

                            foreach ($totalAdsWeekArr as $ads) {
                                echo "<th>" . $ads['Total_Ads_Rejected'] . "</th>";
                            }
                            echo  "<th>#</th>";
                            foreach ($totalAdsMonthArr as $ads) {
                                echo "<th>" . $ads['Total_Ads_Rejected'] . "</th>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>


                <div class="container">
                    <table id="SumLineChart">
                        <tr>
                            <th>#</th>
                            <th>SumDaily</th>
                            <th>#</th>
                            <th>SumWeekly</th>
                            <th>#</th>
                            <th>SumMonthly</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>New User</td>
                            <td>=SUM(AllLineChart!$B$2:$H$2, A2)</td>
                            <td>#</td>
                            <td>=SUM(AllLineChart!$J$2:$M$2, A2)</td>
                            <td>#</td>
                            <td>=SUM(AllLineChart!$O$2:$Z$2, A2)</td>
                        </tr>
                        <tr>
                            <td>Requested Ads</td>
                            <td>=SUM(AllLineChart!$B$3:$H$3, A3)</td>
                            <td>#</td>
                            <td>=SUM(AllLineChart!$J$3:$M$3, A3)</td>
                            <td>#</td>
                            <td>=SUM(AllLineChart!$O$3:$Z$3, A3)</td>
                        </tr>
                        <tr>
                            <th>#</th>
                        </tr>
                        <tr>
                            <td>Approved</td>
                            <td>=SUM(AllLineChart!$B$5:$H$5, A5)</td>
                            <td>#</td>
                            <td>=SUM(AllLineChart!$J$5:$M$5, A5)</td>
                            <td>#</td>
                            <td>=SUM(AllLineChart!$O$5:$Z$5, A5)</td>

                        </tr>
                        <tr>
                            <td>Rejected</td>
                            <td>=SUM(AllLineChart!$B$6:$H$6, A6)</td>
                            <td>#</td>
                            <td>=SUM(AllLineChart!$J$6:$M$6, A6)</td>
                            <td>#</td>
                            <td>=SUM(AllLineChart!$O$6:$Z$6, A6)</td>

                        </tr>
                    </table>
                </div>



                <div class="container">
                    <table id="PieChart">
                        <tr>
                            <th>#</th>
                            <?php
                            foreach ($totalCategoryDayArr as $cat) {
                                echo "<th>" . $cat['category'] . "</th>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Within 7 Days</td>
                            <?php
                            foreach ($totalCategoryDayArr as $cat) {
                                echo "<th>" . $cat['category_count'] . "</th>";
                            }
                            ?>
                        </tr>

                        <tr>
                            <td>#</td>
                        </tr>
                        <tr>
                            <th>#</th>
                            <?php
                            foreach ($totalCategoryWeekArr as $cat) {
                                echo "<th>" . $cat['category'] . "</th>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Within 31 Days</td>
                            <?php
                            foreach ($totalCategoryWeekArr as $cat) {
                                echo "<th>" . $cat['category_count'] . "</th>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>#</td>
                        <tr>
                            <th>#</th>
                            <?php
                            foreach ($totalCategoryMonthArr as $cat) {
                                echo "<th>" . $cat['category'] . "</th>";
                            }
                            ?>
                        </tr>
                        </tr>
                        <tr>
                            <td>Within 12 Months</td>
                            <?php
                            foreach ($totalCategoryMonthArr as $cat) {
                                echo "<th>" . $cat['category_count'] . "</th>";
                            }
                            ?>
                        </tr>

                    </table>
                </div>



            </div>




            <script>
                // Initiazer config for the line charts
                var chartData1 = {
                    datasets: [{
                            label: 'New Users',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: false,
                        },
                        {
                            label: 'Request Ads',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            fill: false,
                        },
                    ],
                };

                var chartData2 = {
                    datasets: [{
                            label: 'Approved Ads',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: false,
                        },
                        {
                            label: 'Rejected Requests',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            fill: false,
                        },
                    ],
                };

                // Pie chart data
                var pieData = {
                    datasets: [{
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                        ],
                    }],
                };

                // Configuration options
                var options = {
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    },
                };

                // Create line charts with initial data
                var ctx1 = document.getElementById('UserReq').getContext('2d');
                var myLineChart1 = new Chart(ctx1, {
                    type: 'line',
                    data: chartData1,
                    options: options,
                });

                var ctx2 = document.getElementById('AcceptRej').getContext('2d');
                var myLineChart2 = new Chart(ctx2, {
                    type: 'line',
                    data: chartData2,
                    options: options,
                });

                // Create pie chart
                var ctx3 = document.getElementById('Sales').getContext('2d');
                var myPieChart = new Chart(ctx3, {
                    type: 'pie',
                    data: pieData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            title: {
                                display: true
                            }
                        }
                    },
                });

                // Set the initial data to daily
                changeData('daily');

                // Function to change data based on the selected time range
                function changeData(range) {
                    var statusElement = document.getElementById("TimeStatus");
                    switch (range) {
                        case 'daily':
                            <?php 
                            if (mysqli_num_rows($totalUsersDay) > 0 && mysqli_num_rows($totalAdsDay)) :
                                $dayArray = [];
                                $categoryArray = [];
                                $totalCategoryArray = [];
                                $totalUsersArray = [];
                                $totalReqAdsArray = [];
                                $totalApprovedArray = [];
                                $totalRejectedArray = [];
                                foreach ($totalUsersDay as $row) {
                                    $dayArray[] = "'" . $row['Registration_Date'] . "'";
                                    $totalUsersArray[] = "'" . $row['Total_Users_Registered'] . "'";
                                }
                                foreach ($totalAdsDay as $row) {
                                    $totalReqAdsArray[] = "'" . $row['Total_Ads_Requested'] . "'";
                                    $totalApprovedArray[] = "'" . $row['Total_Ads_Approved'] . "'";
                                    $totalRejectedArray[] = "'" . $row['Total_Ads_Rejected'] . "'";
                                }
                                foreach($totalCategoryDay as $row) {
                                    $categoryArray[] = "'" . $row['category'] . "'";
                                    $totalCategoryArray[] = "'" . $row['category_count'] . "'";
                                }
                            endif;
                            ?>
                            labelVariable = [<?= implode(",", $dayArray); ?>];
                            pieLabel = "Last 7 Days Total Categories";
                            chartData1.datasets[0].data = [<?= implode(",", $totalUsersArray); ?>];
                            chartData1.datasets[1].data = [<?= implode(",", $totalReqAdsArray); ?>];

                            chartData2.datasets[0].data = [<?= implode(",", $totalApprovedArray); ?>];
                            chartData2.datasets[1].data = [<?= implode(",", $totalRejectedArray); ?>];

                            pieData.labels = [<?= implode(",", $categoryArray); ?>];
                            pieData.datasets[0].data = [<?= implode(",", $totalCategoryArray); ?>];
                            statusElement.textContent = 'Daily Data Selected';
                            break;
                        case 'weekly':
                            <?php 
                            if (mysqli_num_rows($totalUsersWeek) > 0 && mysqli_num_rows($totalAdsWeek)) :
                                $dayArray = [];
                                $categoryArray = [];
                                $totalCategoryArray = [];
                                $totalUsersArray = [];
                                $totalReqAdsArray = [];
                                $totalApprovedArray = [];
                                $totalRejectedArray = [];
                                foreach ($totalUsersWeek as $row) {
                                    $weekArray[] = "'" . $row['Week_Start_Date'] . "'";
                                    $totalUsersArray[] = "'" . $row['Total_Users_Registered'] . "'";
                                }
                                foreach ($totalAdsWeek as $row) {
                                    $totalReqAdsArray[] = "'" . $row['Total_Ads_Requested'] . "'";
                                    $totalApprovedArray[] = "'" . $row['Total_Ads_Approved'] . "'";
                                    $totalRejectedArray[] = "'" . $row['Total_Ads_Rejected'] . "'";
                                }
                                foreach ($totalCategoryWeek as $row) {
                                    $categoryArray[] = "'" . $row['category'] . "'";
                                    $totalCategoryArray[] = "'" . $row['category_count'] . "'";
                                }
                            endif;
                            ?>
                            labelVariable = [<?= implode(",", $weekArray); ?>];
                            pieLabel = "Last 31 Days Total Categories";
                            chartData1.datasets[0].data = [<?= implode(",", $totalUsersArray); ?>];
                            chartData1.datasets[1].data = [<?= implode(",", $totalReqAdsArray); ?>];

                            chartData2.datasets[0].data = [<?= implode(",", $totalApprovedArray); ?>];
                            chartData2.datasets[1].data = [<?= implode(",", $totalRejectedArray); ?>];

                            pieData.labels = [<?= implode(",", $categoryArray); ?>];
                            pieData.datasets[0].data = [<?= implode(",", $totalCategoryArray); ?>];
                            statusElement.textContent = 'Weekly Data Selected';
                            break;
                        case 'monthly':
                            <?php
                            if (mysqli_num_rows($totalUsersMonth) > 0 && mysqli_num_rows($totalAdsMonth)) :
                                $dayArray = [];
                                $categoryArray = [];
                                $totalCategoryArray = [];
                                $totalUsersArray = [];
                                $totalReqAdsArray = [];
                                $totalApprovedArray = [];
                                $totalRejectedArray = [];
                                foreach ($totalUsersMonth as $row) {
                                    $monthArray[] = "'" . $row['Month_Start_Date'] . "'";
                                    $totalUsersArray[] = "'" . $row['Total_Users_Registered'] . "'";
                                }
                                foreach ($totalAdsMonth as $row) {
                                    $totalReqAdsArray[] = "'" . $row['Total_Ads_Requested'] . "'";
                                    $totalApprovedArray[] = "'" . $row['Total_Ads_Approved'] . "'";
                                    $totalRejectedArray[] = "'" . $row['Total_Ads_Rejected'] . "'";
                                }
                                foreach($totalCategoryMonth as $row) {
                                    $categoryArray[] = "'" . $row['category'] . "'";
                                    $totalCategoryArray[] = "'" . $row['category_count'] . "'";
                                }
                            endif;
                            ?>
                            labelVariable = [<?= implode(",", $monthArray); ?>];
                            pieLabel = "Last 12 Months Total Categories";
                            chartData1.datasets[0].data = [<?= implode(",", $totalUsersArray); ?>];
                            chartData1.datasets[1].data = [<?= implode(",", $totalReqAdsArray); ?>];

                            chartData2.datasets[0].data = [<?= implode(",", $totalApprovedArray); ?>];
                            chartData2.datasets[1].data = [<?= implode(",", $totalRejectedArray); ?>];

                            pieData.labels = [<?= implode(",", $categoryArray); ?>];
                            pieData.datasets[0].data = [<?= implode(",", $totalCategoryArray); ?>];
                            statusElement.textContent = 'Monthly Data Selected';
                            break;
                        default:
                            break;
                    }

                    // Update chart data
                    myLineChart1.data.labels = labelVariable;
                    myLineChart1.data.datasets[0].data = chartData1.datasets[0].data;
                    myLineChart1.data.datasets[1].data = chartData1.datasets[1].data;
                    myLineChart1.update();

                    myLineChart2.data.labels = labelVariable;
                    myLineChart2.data.datasets[0].data = chartData2.datasets[0].data;
                    myLineChart2.data.datasets[1].data = chartData2.datasets[1].data;
                    myLineChart2.update();

                    myPieChart.data.datasets[0].data = pieData.datasets[0].data;
                    myPieChart.options.plugins.title.text = pieLabel;
                    myPieChart.data.labels = pieData.labels;
                    myPieChart.update();
                }

                // Function to export line charts to PDF using jspdf
                function exportLineChartsToPDF() {
                    // Create a new jsPDF instance with a larger page (A2)
                    var pdf = new jspdf.jsPDF({
                        orientation: 'landscape',
                        unit: 'mm',
                        format: [594, 420], // A2 size in landscape
                    });

                    // Get the canvas elements
                    var canvas1 = document.getElementById('UserReq');
                    var canvas2 = document.getElementById('AcceptRej');
                    var canvas3 = document.getElementById('Sales');

                    // Convert the canvases to images
                    var imgData1 = canvas1.toDataURL('image/jpeg', 1.0);
                    var imgData2 = canvas2.toDataURL('image/jpeg', 1.0);
                    var imgData3 = canvas3.toDataURL('image/jpeg', 1.0);

                    // Calculate the height as 30% of the PDF page
                    var pageHeight = pdf.internal.pageSize.getHeight();
                    var height = pageHeight * 0.3;

                    // Add the images to the PDF side by side, filling up the entire width
                    var padding = 10; // Adjust the padding value as needed
                    var width = pdf.internal.pageSize.getWidth() / 2 - padding * 2;

                    pdf.addImage(imgData1, 'JPEG', padding, padding, width, height);
                    pdf.addImage(imgData2, 'JPEG', width + padding * 2, padding, width, height);

                    // Extra space for the pie chart
                    var extraSpace = 10;

                    // Add the pie chart to the PDF below the line charts
                    pdf.addImage(imgData3, 'JPEG', padding, height + padding * 2 + extraSpace, pdf.internal.pageSize.getWidth() - padding * 2, height);

                    // Display values below the line charts
                    var extraSpaceLineCharts = 20;

                    // Display values of each x label below the line charts
                    var labels1 = labelVariable;
                    var values1_1 = chartData1.datasets[0].data;
                    var values1_2 = chartData1.datasets[1].data;
                    for (var i = 0; i < labels1.length; i++) {
                        pdf.text(`${labels1[i]}: New User - ${values1_1[i]}, Request Ads - ${values1_2[i]}`, padding + i * (width / labels1.length), height + padding * 2 + extraSpaceLineCharts);
                    }

                    var labels2 = labelVariable;
                    var values2_1 = chartData2.datasets[0].data;
                    var values2_2 = chartData2.datasets[1].data;
                    for (var j = 0; j < labels2.length; j++) {
                        pdf.text(`${labels2[j]}: Accept - ${values2_1[j]}, Reject - ${values2_2[j]}`, width + padding * 2 + j * (width / labels2.length), height + padding * 2 + extraSpaceLineCharts);
                    }

                    // Save the PDF
                    pdf.save('lineCharts.pdf');
                }


                // Function to export Bootstrap table to Excel using xlsx
                function exportTablesToExcel() {
                    // Get the Table elements
                    var AllLineChart = document.getElementById('AllLineChart');
                    var SumLineChart = document.getElementById('SumLineChart');
                    var PieChart = document.getElementById('PieChart');
                    var tableUser = document.getElementById('UserTable');


                    // Create a workbook
                    var wb = XLSX.utils.book_new();

                    // Convert each table to a worksheet
                    var wsAllLineChart = XLSX.utils.table_to_sheet(AllLineChart);
                    var wsSumLineChart = XLSX.utils.table_to_sheet(SumLineChart);
                    var wsPieChart = XLSX.utils.table_to_sheet(PieChart);
                    var wsUser = XLSX.utils.table_to_sheet(tableUser);


                    // Add each worksheet to the workbook with a unique name
                    XLSX.utils.book_append_sheet(wb, wsAllLineChart, "AllLineChart");
                    XLSX.utils.book_append_sheet(wb, wsSumLineChart, "SumLineChart");
                    XLSX.utils.book_append_sheet(wb, wsPieChart, "PieChart")
                    XLSX.utils.book_append_sheet(wb, wsUser, "UserTable")


                    // Save the workbook as an Excel file
                    XLSX.writeFile(wb, 'tablesData.xlsx');
                }
            </script>

</body>

</html>