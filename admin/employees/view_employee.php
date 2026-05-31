<?php

include '../../config/db_connect.php';

$id = $_GET['id'];

$sql = "SELECT * FROM employees WHERE EmployeeID='$id'";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

?>

<h2>Employee Details</h2>

<p>
<strong>ID:</strong>
<?php echo $row['EmployeeID']; ?>
</p>

<p>
<strong>Full Name:</strong>
<?php echo $row['FullName']; ?>
</p>

<p>
<strong>Email:</strong>
<?php echo $row['Email']; ?>
</p>

<p>
<strong>Phone:</strong>
<?php echo $row['Phone']; ?>
</p>

<p>
<strong>Designation:</strong>
<?php echo $row['Designation']; ?>
</p>

<p>
<strong>Salary:</strong>
<?php echo $row['Salary']; ?>
</p>

<p>
<strong>Joining Date:</strong>
<?php echo $row['JoiningDate']; ?>
</p>

<p>
<strong>Status:</strong>
<?php echo $row['Status']; ?>
</p>

<p>
<strong>Department ID:</strong>
<?php echo $row['DepartmentID']; ?>
</p>

<br>

<a href="manage_employee.php">
    Back
</a>