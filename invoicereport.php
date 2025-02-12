<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            margin-top: 50px;
        }
        h2 {
            color: #0056b3;
        }
        .btn-primary {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-primary:hover {
            background-color: #003d7a;
            border-color: #003d7a;
        }
        .table thead {
            background-color: #0056b3;
            color: white;
        }
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 0.25rem;
        }
        .form-select {
            border-radius: 0.25rem;
        }
    </style>
    <script>
        // Form validation
        function validateForm() {
            let startDate = document.forms["reportForm"]["start_date"].value;
            let endDate = document.forms["reportForm"]["end_date"].value;
            
            // Check if dates are selected
            if (!startDate || !endDate) {
                alert("Both start and end dates are required.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Invoice Report</h2>
        <!-- Invoice Report Form -->
        <form name="reportForm" action="invoicereport.php" method="GET" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <button type="submit" name="invoice_report" class="btn btn-primary">Generate Report</button>
        </form>

        <?php if (isset($_GET['invoice_report'])) {
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];

            $stmt = $conn->prepare("
                SELECT 
                    i.invoice_no, i.date, i.customer, c.district, 
                    i.item_count, i.amount 
                FROM 
                    invoice i
                JOIN 
                    customer c ON i.customer = c.id
                WHERE 
                    i.date BETWEEN ? AND ?
            ");
            $stmt->bind_param("ss", $start_date, $end_date);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>
            <h3 class="mt-5">Invoice Report (From <?= $start_date ?> to <?= $end_date ?>)</h3>
            <!-- Invoice Report Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Customer District</th>
                        <th>Item Count</th>
                        <th>Invoice Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['invoice_no'] ?></td>
                            <td><?= $row['date'] ?></td>
                            <td><?= $row['customer'] ?></td>
                            <td><?= $row['district'] ?></td>
                            <td><?= $row['item_count'] ?></td>
                            <td><?= $row['amount'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
