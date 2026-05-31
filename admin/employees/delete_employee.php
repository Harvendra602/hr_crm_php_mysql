<?php

include '../../config/db_connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM employees WHERE EmployeeID='$id'";

if(mysqli_query($conn, $sql)){

    header("Location: manage_employee.php");

} else {

    echo "Delete Failed";

}
?>