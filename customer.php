<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f8f9fa; }
        .container { max-width: 900px; margin-top: 50px; }
        h2 { color: #0056b3; }
        .btn-primary { background-color: #0056b3; border-color: #0056b3; }
        .btn-primary:hover { background-color: #003d7a; border-color: #003d7a; }
        .table thead { background-color: #0056b3; color: white; }
        .invalid-feedback { display: none; }
        .form-control:invalid { border-color: red; }
        .form-control:invalid + .invalid-feedback { display: block; }
    </style>
    <script>
        function validateForm() {
            let contact = document.forms["customerForm"]["contact"].value;
            let contactPattern = /^[0-9]{10}$/;
            if (!contactPattern.test(contact)) {
                alert("Contact number must be exactly 10 digits.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Register Customer</h2>

        <!-- Customer Registration Form -->
        <form name="customerForm" action="customer.php" method="POST" onsubmit="return validateForm()" novalidate>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <select name="title" class="form-select" required>
                    <option value="">Select Title</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                    <option value="Dr">Dr</option>
                </select>
                <div class="invalid-feedback">Please select a title.</div>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" pattern="[A-Za-z]+" required>
                <div class="invalid-feedback">Please enter a valid first name (letters only).</div>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" pattern="[A-Za-z]+" required>
                <div class="invalid-feedback">Please enter a valid last name (letters only).</div>
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Contact Number</label>
                <input type="text" name="contact" class="form-control" pattern="\d{10}" required>
                <div class="invalid-feedback">Contact number must be exactly 10 digits.</div>
            </div>
            <div class="mb-3">
                <label for="district" class="form-label">District</label>
                <select name="district" class="form-select" required>
                    <option value="">Select District</option>
                    <?php
                    $result = $conn->query("SELECT id, district FROM district");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['district']}</option>";
                    }
                    ?>
                </select>
                <div class="invalid-feedback">Please select a district.</div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Register</button>
        </form>

        <!-- PHP Script to Insert Customer Data -->
        <?php
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $contact = $_POST['contact'];
            $district = $_POST['district'];

            $sql = "INSERT INTO customer (title, first_name, last_name, contact_no, district) 
                    VALUES ('$title', '$first_name', '$last_name', '$contact', '$district')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Customer registered successfully!'); window.location.href='customer.php';</script>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        }
        ?>

        <h2 class="mt-5">Customer List</h2>
        <!-- Customer List Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Contact</th>
                    <th>District</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT c.title, c.first_name, c.last_name, c.contact_no, d.district 
                          FROM customer c 
                          INNER JOIN district d ON c.district = d.id";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['title']}</td>
                                <td>{$row['first_name']}</td>
                                <td>{$row['last_name']}</td>
                                <td>{$row['contact_no']}</td>
                                <td>{$row['district']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No customers found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
