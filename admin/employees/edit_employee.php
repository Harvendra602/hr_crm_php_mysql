<?php

include '../../config/db_connect.php';

$id = $_GET['id'];

$sql = "SELECT * FROM employees WHERE EmployeeID='$id'";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $designation = $_POST['designation'];
    $salary = $_POST['salary'];
    $joiningdate = $_POST['joiningdate'];
    $status = $_POST['status'];
    $departmentid = $_POST['departmentid'];

    $update = "UPDATE employees SET

    FullName='$fullname',
    Email='$email',
    Phone='$phone',
    Designation='$designation',
    Salary='$salary',
    JoiningDate='$joiningdate',
    Status='$status',
    DepartmentID='$departmentid'

    WHERE EmployeeID='$id'";

    if(mysqli_query($conn, $update)){

        header("Location: manage_employee.php");

    } else {

        echo "Update Failed";

    }
}
?>

<h2>Edit Employee</h2>

<form method="POST">

    <label>Full Name</label><br>
    <input type="text" name="fullname"
    value="<?php echo $row['FullName']; ?>">
    <br><br>

    <label>Email</label><br>
    <input type="email" name="email"
    value="<?php echo $row['Email']; ?>">
    <br><br>

    <label>Phone</label><br>
    <input type="text" name="phone"
    value="<?php echo $row['Phone']; ?>">
    <br><br>

    <label>Designation</label><br>
    <input type="text" name="designation"
    value="<?php echo $row['Designation']; ?>">
    <br><br>

    <label>Salary</label><br>
    <input type="text" name="salary"
    value="<?php echo $row['Salary']; ?>">
    <br><br>

    <label>Joining Date</label><br>
    <input type="date" name="joiningdate"
    value="<?php echo $row['JoiningDate']; ?>">
    <br><br>

    <label>Status</label><br>
    <input type="text" name="status"
    value="<?php echo $row['Status']; ?>">
    <br><br>

    <label>Department ID</label><br>
    <input type="text" name="departmentid"
    value="<?php echo $row['DepartmentID']; ?>">
    <br><br>

    <button type="submit" name="update">
        Update Employee
    </button>

</form>