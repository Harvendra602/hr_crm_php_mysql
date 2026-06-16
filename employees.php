<?php

include 'config/db_connect.php';

$query = "SELECT * FROM employees";

$result = mysqli_query($conn, $query);

?>

<!-- This single file teaches:

database connection
SELECT query
mysqli_query()
mysqli_fetch_assoc()
while loop
dynamic HTML table
PHP inside HTML

This is core PHP backend workflow. -->

<!DOCTYPE html>
<html>
<head>
    <title>Employees List</title>

    <style>

        body{
            font-family: Arial;
            padding: 20px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        th, td{
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th{
            background-color: #f2f2f2;
        }

    </style>

</head>
<body>

    <h2>Employees List</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Salary</th>
            <th>Status</th>
        </tr>

        <?php

        while($row = mysqli_fetch_assoc($result)){

        ?>

        <tr>

            <td><?php echo $row['EmployeeID']; ?></td>

            <td><?php echo $row['FullName']; ?></td>

            <td><?php echo $row['Email']; ?></td>

            <td><?php echo $row['Phone']; ?></td>

            <td><?php echo $row['Department']; ?></td>

            <td><?php echo $row['Designation']; ?></td>

            <td><?php echo $row['Salary']; ?></td>

            <td><?php echo $row['Status']; ?></td>

        </tr>

        <?php
        }
        ?>

    </table>

</body>
</html>