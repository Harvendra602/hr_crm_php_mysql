<?php

header("Content-Type: application/json");

include "../../config/db_connect.php";

if (
    isset($_POST['EmployeeID']) &&
    isset($_POST['FullName']) &&
    isset($_POST['Email']) &&
    isset($_POST['Phone'])
) {

    $id = $_POST['EmployeeID'];
    $fullName = $_POST['FullName'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];

    $sql = "UPDATE employees
            SET FullName='$fullName',
                Email='$email',
                Phone='$phone'
            WHERE EmployeeID=$id";

    if (mysqli_query($conn, $sql)) {

        echo json_encode([
            "success" => true,
            "message" => "Employee updated successfully"
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
        "message" => "Required fields are missing"
    ]);

}

?>