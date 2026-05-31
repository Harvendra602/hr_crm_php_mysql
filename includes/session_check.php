<?php

session_start();

if(!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_logged_in'])){
    header("Location: ../../auth/login.php");
    exit();
}
