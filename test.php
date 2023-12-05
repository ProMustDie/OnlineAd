<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart.js Line Graphs Export to PDF</title>
    <!-- Include Bootstrap CSS for grid system -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include jspdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Create canvases for the charts with increased height and Bootstrap classes -->
            <div class="col-12 col-md-6">
                <canvas id="myLineChart1" width="400" height="200"></canvas>
            </div>
            <div class="col-12 col-md-6">
                <canvas id="myLineChart2" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Bootstrap Table -->
    <div class="container mt-3">
        <h2>Bootstrap Table</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>10</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>20</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>30</td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-primary" onclick="exportTableToPDF()">Export Table to PDF</button>
    </div>

    <!-- Buttons for changing the data range -->
    <div class="container mt-3">
        <button onclick="changeData('daily')">Daily</button>
        <button onclick="changeData('weekly')">Weekly</button>
        <button onclick="changeData('monthly')">Monthly</button>
    </div>

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

        // Configuration options
        var options = {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        };

        // Create line charts with initial data
        var ctx1 = document.getElementById('myLineChart1').getContext('2d');
        var myLineChart1 = new Chart(ctx1, {
            type: 'line',
            data: chartData1,
            options: options,
        });

        var ctx2 = document.getElementById('myLineChart2').getContext('2d');
        var myLineChart2 = new Chart(ctx2, {
            type: 'line',
            data: chartData2,
            options: options,
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
                    break;
                case 'weekly':
                    chartData1.labelVariable = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    chartData1.datasets[0].data = [10, 15, 25, 20];
                    chartData1.datasets[1].data = [12, 18, 22, 28];

                    chartData2.labelVariable = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    chartData2.datasets[0].data = [10, 15, 25, 20];
                    chartData2.datasets[1].data = [5, 8, 15, 10];
                    break;
                case 'monthly':
                    chartData1.labelVariable = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    chartData1.datasets[0].data = [5, 12, 22, 18, 30, 28, 15, 10, 25, 20, 35, 40];
                    chartData1.datasets[1].data = [8, 15, 25, 20, 30, 32, 18, 12, 28, 22, 40, 45];

                    chartData2.labelVariable = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    chartData2.datasets[0].data = [15, 22, 32, 28, 40, 38, 25, 20, 35, 30, 45, 50];
                    chartData2.datasets[1].data = [10, 18, 28, 22, 35, 40, 15, 8, 20, 18, 30, 38];
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
            var canvas1 = document.getElementById('myLineChart1');
            var canvas2 = document.getElementById('myLineChart2');

            // Convert the canvases to images
            var imgData1 = canvas1.toDataURL('image/jpeg', 1.0);
            var imgData2 = canvas2.toDataURL('image/jpeg', 1.0);

            // Calculate the height as 30% of the PDF page
            var pageHeight = pdf.internal.pageSize.getHeight();
            var height = pageHeight * 0.3;

            // Add the images to the PDF side by side, filling up the entire width
            var padding = 10; // Adjust the padding value as needed
            var width = pdf.internal.pageSize.getWidth() / 2 - padding * 2;

            pdf.addImage(imgData1, 'JPEG', padding, padding, width, height);
            pdf.addImage(imgData2, 'JPEG', width + padding * 2, padding, width, height);

            // Extra space for values below the images
            var extraSpace = 20;

            // Display values of each x label below each graph
            var labels1 = chartData1.labelVariable;
            var values1_1 = chartData1.datasets[0].data;
            var values1_2 = chartData1.datasets[1].data;
            for (var i = 0; i < labels1.length; i++) {
                pdf.text(`${labels1[i]}: New User - ${values1_1[i]}, Request Ads - ${values1_2[i]}`, padding + i * (width / labels1.length), height + padding + extraSpace);
            }

            var labels2 = chartData2.labelVariable;
            var values2_1 = chartData2.datasets[0].data;
            var values2_2 = chartData2.datasets[1].data;
            for (var j = 0; j < labels2.length; j++) {
                pdf.text(`${labels2[j]}: Accept - ${values2_1[j]}, Reject - ${values2_2[j]}`, width + padding * 2 + j * (width / labels2.length), height + padding + extraSpace);
            }

            // Save the PDF
            pdf.save('lineCharts.pdf');
        }

        // Function to export Bootstrap table to PDF using jspdf
        function exportTableToPDF() {
            // Create a new jsPDF instance
            var pdf = new jspdf.jsPDF();

            // Get the Table element
            var table = document.querySelector('.table');

            // Convert Table to HTML string
            var tableHtml = table.outerHTML;

            // Add HTML to PDF
            pdf.fromHTML(tableHtml, 15, 15);

            // Save the PDF
            pdf.save('tableData.pdf');
        }
    </script>

    <!-- Button to trigger PDF export -->
    <button class="btn btn-primary mt-3" onclick="exportLineChartsToPDF()">Export Line Charts to PDF</button>
</body>

</html>