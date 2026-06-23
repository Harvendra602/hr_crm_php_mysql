<?php

header("Content-Type: application/json");

include "../../config/db_connect.php";

if(isset($_POST['full_name'])){

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $designation = $_POST['designation'];
    $salary = $_POST['salary'];
    $joining_date = $_POST['joining_date'];
    $status = $_POST['status'];
    $department_id = $_POST['department_id'];

    $sql = "INSERT INTO employees
            (FullName, Email, Phone, Designation, Salary, JoiningDate, Status, DepartmentID)

            VALUES

            ('$full_name',
             '$email',
             '$phone',
             '$designation',
             '$salary',
             '$joining_date',
             '$status',
             '$department_id')";

    if(mysqli_query($conn, $sql)){

        echo json_encode([
            "success" => true,
            "message" => "Employee created successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => mysqli_error($conn)
        ]);

    }

} else {

    echo json_encode([
        "success" => false,
        "message" => "No data received"
    ]);

}

?>