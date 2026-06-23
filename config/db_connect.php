<?php

$host = "localhost";
$username = "root";
$password = "root123";
$database = "hr_crm";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>