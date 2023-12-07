<?php include('includes/app.php');
include_once('includes/Classified.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>



<body class="bg-dark">


    <?php
    include("Includes/navbar.php");
    ?>

    <!-- //!date range picker -->

    <div class="container-fluid d-flex align-items-center justify-content-center p-4">

        <div class="ms-auto">
            <button type="button" class="btn btn-outline-primary" onclick="exportLineChartsToPDF()">Export Line Charts
                to PDF</button>
            <button type="button" class="btn btn-outline-info" onclick="exportTableToExcel()">Export Table to
                Excel</button>
        </div>

        <div class="ms-5 me-5">
            <button type="button" class="btn btn-outline-primary" onclick="changeData('daily')">Daily</button>
            <button type="button" class="btn btn-outline-info" onclick="changeData('weekly')">Weekly</button>
            <button type="button" class="btn btn-outline-success" onclick="changeData('monthly')">Monthly</button>
        </div>
        <div class=""><span class="fw-bold fs-5 text-light pe-2 ps-5">Calender: </span></div>
        <div class="">
            <input type="text" name="daterange" class="form-control w-100 d-inline" />
        </div>
    </div>

    <!-- //!2 graphs -->
    <div class="container-fluid text-center ">



        <div class="row">
            <div class="col-6 bg-light">
                <div class="p-1" style="height: 22rem;">
                    <div class="container-fluid"> <canvas id="UserReq" width="400" height="190"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-6 bg-warning">
                <div class="p-1" style="height: 22rem;">
                    <div class="container-fluid"> <canvas id="AcceptRej" width="400" height="190"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- //!table and sales -->
        <div class="row mt-3">

            <div class="col-6 bg-warning">
                <div class="overflow-y-scroll" style="height: 24rem;">
                    <div class="table-responsive p-2 m-0">
                        <table class="table caption-top table-striped table-hover table-bordered border-secondary table-sm">
                            <caption>List of users inquiries</caption>
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">AdName</th>
                                    <th scope="col">AdCategory</th>
                                    <th scope="col">AdPrice</th>
                                    <th scope="col">AdStatus</th>
                                    <th scope="col">AdPosted</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <div class="col-6 bg-info">
                <div class="row p-2 g-2 d-flex" style="height: 25rem;">
                    <div class="col-6 container-fluid ">
                        <canvas id="Sales" width="50" height="50"></canvas>
                    </div>
                    <div class="col-6 container-fluid p-0 m-0 pe-2">
                        <div class="table-responsive">
                            <table class="table caption-top table-striped table-hover table-bordered border-secondary table-sm">
                                <caption>Sales</caption>
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">AdCategory</th>
                                        <th scope="col">Chosen</th>
                                        <th scope="col">Sales</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>@fat</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>the Bird</td>
                                        <td>@twitter</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>the Bird</td>
                                        <td>@twitter</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>the Bird</td>
                                        <td>@twitter</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>the Bird</td>
                                        <td>@twitter</td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <!-- //!Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>


    <!-- //!Date range picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
    <!-- //!Date range picker -->



    <!-- //!Date range picker -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <!-- //!Date range picker -->

    <!-- //!chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initial data for the line charts
        var chartData1 = {
            labelVariable: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            datasets: [{
                    label: 'New User',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false,
                    data: [4, 10, 20, 15, 30],
                },
                {
                    label: 'Request Ads',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false,
                    data: [6, 12, 18, 25, 22],
                },
            ],
        };

        var chartData2 = {
            labelVariable: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                    label: 'Accept',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false,
                    data: [10, 15, 25, 20],
                },
                {
                    label: 'Reject',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false,
                    data: [5, 8, 15, 10],
                },
            ],
        };

        // Pie chart data
        var pieData = {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: 'Sales',
                data: [12, 19, 3, 5, 2, 3],
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
                        display: true,
                        text: 'Sales Chart'
                    }
                }
            },
        });

        // Set the initial data to daily
        changeData('daily');

        // Function to change data based on the selected time range
        function changeData(range) {
            switch (range) {
                case 'daily':
                    chartData1.labelVariable = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                    chartData1.datasets[0].data = [4, 10, 20, 15, 30];
                    chartData1.datasets[1].data = [6, 12, 18, 25, 22];

                    chartData2.labelVariable = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                    chartData2.datasets[0].data = [4, 10, 20, 15, 30];
                    chartData2.datasets[1].data = [2, 5, 10, 8, 12];

                    pieData.labels = ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'];
                    pieData.datasets[0].data = [12, 19, 3, 5, 2, 3];
                    break;
                case 'weekly':
                    chartData1.labelVariable = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    chartData1.datasets[0].data = [10, 15, 25, 20];
                    chartData1.datasets[1].data = [12, 18, 22, 28];

                    chartData2.labelVariable = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    chartData2.datasets[0].data = [10, 15, 25, 20];
                    chartData2.datasets[1].data = [5, 8, 15, 10];

                    pieData.labels = ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'];
                    pieData.datasets[0].data = [15, 22, 32, 28, 40, 38];
                    break;
                case 'monthly':
                    chartData1.labelVariable = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    chartData1.datasets[0].data = [5, 12, 22, 18, 30, 28, 15, 10, 25, 20, 35, 40];
                    chartData1.datasets[1].data = [8, 15, 25, 20, 30, 32, 18, 12, 28, 22, 40, 45];

                    chartData2.labelVariable = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    chartData2.datasets[0].data = [15, 22, 32, 28, 40, 38, 25, 20, 35, 30, 45, 50];
                    chartData2.datasets[1].data = [10, 18, 28, 22, 35, 40, 15, 8, 20, 18, 30, 38];

                    pieData.labels = ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'];
                    pieData.datasets[0].data = [25, 32, 42, 38, 50, 48];
                    break;
                default:
                    break;
            }

            // Update chart data
            myLineChart1.data.labels = chartData1.labelVariable;
            myLineChart1.data.datasets[0].data = chartData1.datasets[0].data;
            myLineChart1.data.datasets[1].data = chartData1.datasets[1].data;
            myLineChart1.update();

            myLineChart2.data.labels = chartData2.labelVariable;
            myLineChart2.data.datasets[0].data = chartData2.datasets[0].data;
            myLineChart2.data.datasets[1].data = chartData2.datasets[1].data;
            myLineChart2.update();

            myPieChart.data.labels = pieData.labels;
            myPieChart.data.datasets[0].data = pieData.datasets[0].data;
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
            var labels1 = chartData1.labelVariable;
            var values1_1 = chartData1.datasets[0].data;
            var values1_2 = chartData1.datasets[1].data;
            for (var i = 0; i < labels1.length; i++) {
                pdf.text(`${labels1[i]}: New User - ${values1_1[i]}, Request Ads - ${values1_2[i]}`, padding + i * (width / labels1.length), height + padding * 2 + extraSpaceLineCharts);
            }

            var labels2 = chartData2.labelVariable;
            var values2_1 = chartData2.datasets[0].data;
            var values2_2 = chartData2.datasets[1].data;
            for (var j = 0; j < labels2.length; j++) {
                pdf.text(`${labels2[j]}: Accept - ${values2_1[j]}, Reject - ${values2_2[j]}`, width + padding * 2 + j * (width / labels2.length), height + padding * 2 + extraSpaceLineCharts);
            }

            // Save the PDF
            pdf.save('lineCharts.pdf');
        }

        // Function to export Bootstrap table to Excel using xlsx
        function exportTableToExcel() {
            // Get the Table element
            var table = document.querySelector('.table');

            // Convert Table to worksheet
            var ws = XLSX.utils.table_to_sheet(table);

            // Create a workbook with a single sheet
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

            // Save the workbook as an Excel file
            XLSX.writeFile(wb, 'tableData.xlsx');
        }
    </script>



</body>

</html>