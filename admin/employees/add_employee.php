<?php

include '../../config/db_connect.php';
include '../../includes/session_check.php';

/*
FETCH DEPARTMENTS
*/
$department_sql = "SELECT * FROM departments";
$department_result = mysqli_query($conn, $department_sql);

/*
ADD EMPLOYEE
*/
if(isset($_POST['add_employee'])){

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $designation = $_POST['designation'];
    $salary = $_POST['salary'];
    $joining_date = $_POST['joining_date'];
    $status = $_POST['status'];
    $department_id = $_POST['department_id'];

    $sql = "INSERT INTO employees
    (FullName, Email, Phone, Designation, Salary, JoiningDate, Status, DepartmentID)

    VALUES

    ('$full_name',
     '$email',
     '$phone',
     '$designation',
     '$salary',
     '$joining_date',
     '$status',
     '$department_id')";

    if(mysqli_query($conn, $sql)){

        echo "Employee Added Successfully";

    } else {

        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
</head>
<body>

<h2>Add Employee</h2>

<form method="POST">

    <label>Full Name:</label><br>
    <input type="text" name="full_name" required>
    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required>
    <br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone">
    <br><br>

    <label>Designation:</label><br>
    <input type="text" name="designation">
    <br><br>

    <label>Salary:</label><br>
    <input type="number" step="0.01" name="salary">
    <br><br>

    <label>Joining Date:</label><br>
    <input type="date" name="joining_date">
    <br><br>

    <label>Status:</label><br>

    <select name="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>

    <br><br>

    <label>Department:</label><br>

    <select name="department_id" required>

        <option value="">Select Department</option>

        <?php while($department = mysqli_fetch_assoc($department_result)) { ?>

            <option value="<?php echo $department['DepartmentID']; ?>">

                <?php echo $department['DepartmentName']; ?>

            </option>

        <?php } ?>

    </select>

    <br><br>

    <button type="submit" name="add_employee">
        Add Employee
    </button>

</form>

<br>

<a href="manage_employee.php">
    Manage Employees
</a>

</body>
</html>