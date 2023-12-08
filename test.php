<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables Side by Side</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .table-container {
            display: flex;
            justify-content: space-around;
        }

        table {
            border-collapse: collapse;
            width: 300px;
            margin: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        #exportButton {
            margin-top: 20px;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="table-container">
        <table id="table1">
            <caption>Table 1</caption>
            <thead>
                <tr>
                    <th>Header 1</th>
                    <th>Header 2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Data 1.1</td>
                    <td>Data 1.2</td>
                </tr>
                <tr>
                    <td>Data 2.1</td>
                    <td>Data 2.2</td>
                </tr>
            </tbody>
        </table>

        <table id="table2">
            <caption>Table 2</caption>
            <thead>
                <tr>
                    <th>Header A</th>
                    <th>Header B</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Data A.1</td>
                    <td>Data B.1</td>
                </tr>
                <tr>
                    <td>Data A.2</td>
                    <td>Data B.2</td>
                </tr>
            </tbody>
        </table>
    </div>

    <button id="exportButton" onclick="exportToExcel()">Export to Excel</button>

    <script>
        function exportToExcel() {
            const tables = [document.getElementById('table1'), document.getElementById('table2')];
            const wb = XLSX.utils.book_new();

            tables.forEach((table, index) => {
                const ws = XLSX.utils.table_to_sheet(table);
                XLSX.utils.book_append_sheet(wb, ws, `Sheet${index + 1}`);
            });

            XLSX.writeFile(wb, 'tables_export.xlsx');
        }
    </script>
</body>

</html>