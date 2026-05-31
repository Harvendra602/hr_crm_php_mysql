<?php

include 'config/db_connect.php';

if(isset($_POST['submit'])){

    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $plain_password = $_POST['password'];

    $password = password_hash($plain_password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = "SELECT * FROM admin WHERE Email='$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0){

        echo "Email already exists!";

    } else {

        $sql = "INSERT INTO admin (FullName, Email, Password)
                VALUES ('$name', '$email', '$password')";

        if(mysqli_query($conn, $sql)){
            echo "Admin Created Successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Admin</title>
</head>
<body>

<h2>Create Admin</h2>

<form method="POST">

    <label>Full Name</label><br>
    <input type="text" name="fullname" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="submit">
        Create Admin
    </button>

</form>

</body>
</html>