<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Management</title>
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
        .invalid-feedback {
            display: none;
        }
        .form-control:invalid {
            border-color: red;
        }
        .form-control:invalid + .invalid-feedback {
            display: block;
        }
    </style>
    <script>
        // Form validation
        function validateForm() {
            let itemCode = document.forms["itemForm"]["item_code"].value;
            let itemName = document.forms["itemForm"]["item_name"].value;
            let quantity = document.forms["itemForm"]["quantity"].value;
            let unitPrice = document.forms["itemForm"]["unit_price"].value;
            
            // Check if item code or item name is empty
            if (!itemCode || !itemName) {
                alert("Item code and name are required.");
                return false;
            }

            // Validate quantity and unit price
            if (quantity <= 0) {
                alert("Quantity must be a positive number.");
                return false;
            }
            if (unitPrice <= 0) {
                alert("Unit price must be a positive number.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Register Item</h2>
        <!-- Item Registration Form -->
        <form name="itemForm" action="item.php" method="POST" onsubmit="return validateForm()" novalidate>
            <div class="mb-3">
                <label for="item_code" class="form-label">Item Code</label>
                <input type="text" name="item_code" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="item_name" class="form-label">Item Name</label>
                <input type="text" name="item_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="item_category" class="form-label">Item Category</label>
                <select name="item_category" class="form-select" required>
                    <?php
                    $category_result = $conn->query("SELECT id, category FROM item_category");
                    while ($row = $category_result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['category']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="item_sub_category" class="form-label">Item Subcategory</label>
                <select name="item_sub_category" class="form-select" required>
                    <?php
                    $subcategory_result = $conn->query("SELECT id, sub_category FROM item_subcategory");
                    while ($row = $subcategory_result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['sub_category']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" required min="1">
            </div>
            <div class="mb-3">
                <label for="unit_price" class="form-label">Unit Price</label>
                <input type="number" name="unit_price" class="form-control" required step="0.01" min="0.01">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Register Item</button>
        </form>

        <h2 class="mt-5">Item List</h2>
        <!-- Item List Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Category ID</th>
                    <th>Subcategory ID</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM item");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['item_code']}</td>
                        <td>{$row['item_name']}</td>
                        <td>{$row['item_category']}</td>
                        <td>{$row['item_subcategory']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['unit_price']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $item_code = $_POST['item_code'];
        $item_name = $_POST['item_name'];
        $item_category = $_POST['item_category'];
        $item_sub_category = $_POST['item_sub_category'];
        $quantity = $_POST['quantity'];
        $unit_price = $_POST['unit_price'];

        $sql = "INSERT INTO item (item_code, item_name, item_category, item_subcategory, quantity, unit_price) 
                VALUES ('$item_code', '$item_name', '$item_category', '$item_sub_category', '$quantity', '$unit_price')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Item registered successfully'); window.location.href='item.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
