<?php

header("Content-Type: application/json");

include "../../config/db_connect.php";

if(isset($_POST['department_name'])){

    $department_name = $_POST['department_name'];

    $sql = "INSERT INTO departments (DepartmentName)
            VALUES ('$department_name')";

    if(mysqli_query($conn,$sql)){

        echo json_encode([
            "success"=>true,
            "message"=>"Department created successfully"
        ]);

    }else{

        echo json_encode([
            "success"=>false,
            "message"=>mysqli_error($conn)
        ]);
    }

}
?>