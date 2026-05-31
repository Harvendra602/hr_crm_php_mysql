<?php

session_start();

include '../config/db_connect.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Demo Login Check

    if($email == "admin@gmail.com" && $password == "123456"){

        $_SESSION['admin_logged_in'] = true;

        header("Location: ../admin/dashboard.php");

        exit();

    }else{

        $error = "Invalid Email or Password";

    }

}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Admin Login</title>

</head>

<body>

<h2>Admin Login</h2>

<?php

if(isset($error)){
    echo "<p style='color:red;'>$error</p>";
}

?>

<form method="POST">

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">
        Login
    </button>

</form>

</body>
</html>