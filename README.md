Start XAMPP and ensure that Apache and MySQL services are running.

Open your browser and go to phpMyAdmin: http://localhost/phpmyadmin/

Click on Databases, then Create a new database named assignment.

Click on the newly created database and select Import.

Click Choose File and select the assignment.sql file.

Click Go to import the database.

2. Extract and Move Files to htdocs

Extract the Csquare Company assignment.zip file.

Copy the extracted folder and paste it inside XAMPP's htdocs directory (e.g., C:\xampp\htdocs\Csquare Company assignment).

3. Configure Database Connection

Open the db.php file inside the project folder.

Ensure the database credentials match your XAMPP setup:

$servername = "localhost";
$username = "root"; // Default XAMPP user
$password = ""; // Leave blank for XAMPP
$dbname = "Assignment";

4. Run the Project

Open your browser and enter the following URL:

http://localhost/Csquare Company assignment/customer.php

The Customer Management System should now be visible.

5. Open Additional Files

To open customer.php: Navigate to http://localhost/Csquare Company assignment/customer.php

To open item.php: Navigate to http://localhost/Csquare Company assignment/item.php

To open other files, replace the filename in the URL accordingly.
