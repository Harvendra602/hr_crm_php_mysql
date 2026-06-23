<?php

header("Content-Type: application/json");

include "../../config/db_connect.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM employees WHERE EmployeeID = $id";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $employee = mysqli_fetch_assoc($result);

        echo json_encode($employee);

    } else {

        echo json_encode([
            "message" => "Employee not found"
        ]);
    }

} else {

    echo json_encode([
        "message" => "Employee ID is required"
    ]);
}

?>