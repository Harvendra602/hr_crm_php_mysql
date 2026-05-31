<?php

session_start();

include '../config/db_connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM admin WHERE Email='$email'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    $admin = mysqli_fetch_assoc($result);

    // Verify Password
    if(password_verify($password, $admin['Password'])){

        $_SESSION['admin_id'] = $admin['AdminID'];
        $_SESSION['admin_name'] = $admin['FullName'];

        header("Location: ../admin/dashboard.php");
        exit();

    } else {

        echo "Wrong Password";

    }

} else {

    echo "Admin Not Found";

}
?>