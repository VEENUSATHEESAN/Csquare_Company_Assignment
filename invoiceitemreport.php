<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Item Report</title>
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
        h2, h3 {
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
            let startDate = document.forms["reportForm"]["item_start_date"].value;
            let endDate = document.forms["reportForm"]["item_end_date"].value;
            
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
        <h2 class="mt-5">Invoice Item Report</h2>
        <!-- Invoice Item Report Form -->
        <form name="reportForm" action="invoiceitemreport.php" method="GET" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="item_start_date" class="form-label">Start Date</label>
                <input type="date" name="item_start_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="item_end_date" class="form-label">End Date</label>
                <input type="date" name="item_end_date" class="form-control" required>
            </div>
            <button type="submit" name="item_report" class="btn btn-primary">Generate Report</button>
        </form>

        <?php if (isset($_GET['item_report'])) {
            $item_start_date = $_GET['item_start_date'];
            $item_end_date = $_GET['item_end_date'];

            $stmt = $conn->prepare("
                SELECT 
                    i.invoice_no AS invoice_number,
                    i.date AS invoiced_date,
                    c.first_name AS customer_name,
                    it.item_name,
                    it.item_code,
                    it.item_category,
                    it.unit_price AS item_unit_price
                FROM 
                    invoice i
                JOIN 
                    customer c ON i.customer = c.id
                JOIN 
                    item it ON i.invoice_no = i.invoice_no
                WHERE 
                    i.date BETWEEN ? AND ?
            ");
            $stmt->bind_param("ss", $item_start_date, $item_end_date);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>
            <h3 class="mt-5">Invoice Item Report (From <?= $item_start_date ?> to <?= $item_end_date ?>)</h3>
            <!-- Invoice Item Report Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Invoiced Date</th>
                        <th>Customer Name</th>
                        <th>Item Name</th>
                        <th>Item Code</th>
                        <th>Item Category</th>
                        <th>Item Unit Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['invoice_number'] ?></td>
                            <td><?= $row['invoiced_date'] ?></td>
                            <td><?= $row['customer_name'] ?></td>
                            <td><?= $row['item_name'] ?></td>
                            <td><?= $row['item_code'] ?></td>
                            <td><?= $row['item_category'] ?></td>
                            <td><?= $row['item_unit_price'] ?></td>
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
