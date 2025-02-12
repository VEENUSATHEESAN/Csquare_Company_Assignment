<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Report</title>
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
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Item Report</h2>
        <!-- Item Report Form -->
        <form action="itemreport.php" method="GET">
            <button type="submit" name="item_summary_report" class="btn btn-primary">Generate Report</button>
        </form>

        <?php if (isset($_GET['item_summary_report'])) {
            $stmt = $conn->prepare("
                SELECT 
                    item_name, 
                    item_category, 
                    item_subcategory, 
                    SUM(quantity) as total_quantity 
                FROM 
                    item 
                GROUP BY 
                    item_name, item_category, item_subcategory
            ");
            $stmt->execute();
            $result = $stmt->get_result();
        ?>
            <h3 class="mt-5">Item Summary Report</h3>
            <!-- Item Summary Report Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Total Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['item_name'] ?></td>
                            <td><?= $row['item_category'] ?></td>
                            <td><?= $row['item_subcategory'] ?></td>
                            <td><?= $row['total_quantity'] ?></td>
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
