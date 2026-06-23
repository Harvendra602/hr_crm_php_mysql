<?php

header("Content-Type: application/json");

include "../../config/db_connect.php";

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "SELECT * FROM departments WHERE DepartmentID = $id";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $department = mysqli_fetch_assoc($result);

        echo json_encode($department);

    }else{

        echo json_encode([
            "success"=>false,
            "message"=>"Department not found"
        ]);

    }

}
?>