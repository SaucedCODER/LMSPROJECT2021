<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Reports</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Reports</h1>

        <!-- Report options -->
        <div class="mb-3">
            <label for="reportType" class="form-label">Select Report Type:</label>
            <select class="form-select" id="reportType">
                <option value="userActivity">User Activity</option>
                <option value="bookInventory">Book Inventory</option>
                <!-- Add more report options as needed -->
            </select>
        </div>

        <!-- Report display area -->
        <div id="reportDisplay">
            <!-- The generated report content will be displayed here -->
        </div>

        <!-- Generate Report button -->
        <button class="btn btn-primary" onclick="generateReport()">Generate Report</button>
    </div>

    <!-- Bootstrap JavaScript link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function generateReport() {
            const reportType = document.getElementById('reportType').value;
            const reportDisplay = document.getElementById('reportDisplay');

            // You can fetch and display the selected report here
            // Example: Use AJAX to fetch the report data and populate the reportDisplay div
            // Replace the following lines with your actual report generation logic
            reportDisplay.innerHTML = '<h2>Generated Report for ' + reportType + '</h2>';
            reportDisplay.innerHTML += '<p>This is a sample report content.</p>';
        }
    </script>
</body>

</html>