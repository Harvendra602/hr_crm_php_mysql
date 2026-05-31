<?php

include '../../config/db_connect.php';
include '../../includes/session_check.php';

$id = $_GET['id'];

$sql = "SELECT * FROM departments WHERE DepartmentID='$id'";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update_department'])){

    $department_name = $_POST['department_name'];

    $update_sql = "UPDATE departments
                   SET DepartmentName='$department_name'
                   WHERE DepartmentID='$id'";

    if(mysqli_query($conn, $update_sql)){
        header("Location: manage_department.php");
        exit();
    } else {
        echo "Error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Department</title>
</head>
<body>

<h2>Edit Department</h2>

<form method="POST">

    <label>Department Name:</label><br>

    <input type="text"
           name="department_name"
           value="<?php echo $row['DepartmentName']; ?>"
           required>

    <br><br>

    <button type="submit" name="update_department">
        Update Department
    </button>

</form>

</body>
</html>