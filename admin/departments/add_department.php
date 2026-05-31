<?php

include '../../config/db_connect.php';
include '../../includes/session_check.php';

if(isset($_POST['add_department'])){

    $department_name = $_POST['department_name'];

    $sql = "INSERT INTO departments (DepartmentName)
            VALUES ('$department_name')";

    if(mysqli_query($conn, $sql)){
        echo "Department Added Successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Department</title>
</head>
<body>

<h2>Add Department</h2>

<form method="POST">

    <label>Department Name:</label><br>
    <input type="text" name="department_name" required><br><br>

    <button type="submit" name="add_department">
        Add Department
    </button>

</form>

<br>

<a href="manage_department.php">
    Manage Departments
</a>

</body>
</html>