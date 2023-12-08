<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Tables to Excel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
</head>

<body>

    <!-- First HTML Table -->
    <table id="table1" border="1">
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
            <th>Column 3</th>
        </tr>
        <tr>
            <td>1-1</td>
            <td>1-2</td>
            <td>1-3</td>
        </tr>
        <tr>
            <td>2-1</td>
            <td>2-2</td>
            <td>2-3</td>
        </tr>
    </table>

    <br>

    <!-- Second HTML Table -->
    <table id="table2" border="1">
        <tr>
            <th>Column A</th>
            <th>Column B</th>
            <th>Column C</th>
        </tr>
        <tr>
            <td>A-1</td>
            <td>B-1</td>
            <td>C-1</td>
        </tr>
        <tr>
            <td>A-2</td>
            <td>B-2</td>
            <td>C-2</td>
        </tr>
    </table>

    <br>

    <!-- Button to trigger the export -->
    <button onclick="exportTablesToExcel()">Export Tables to Excel</button>

    <script>
        function exportTablesToExcel() {
            // Get the Table elements
            var table1 = document.getElementById('table1');
            var table2 = document.getElementById('table2');

            // Convert each table to a sheet
            var ws1 = XLSX.utils.table_to_sheet(table1);
            var ws2 = XLSX.utils.table_to_sheet(table2);

            // Concatenate the sheets
            var wsMerged = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wsMerged, ws1, 'Table1');
            XLSX.utils.book_append_sheet(wsMerged, ws2, 'Table2');

            // Save the workbook as an Excel file
            XLSX.writeFile(wsMerged, 'combinedTablesData.xlsx');
        }
    </script>

</body>

</html>