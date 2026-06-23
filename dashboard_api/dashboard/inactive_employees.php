<?php

header("Content-Type: application/json");

include "../../config/db_connect.php";

$sql = "SELECT COUNT(*) AS inactive_employees
        FROM employees
        WHERE Status = 'Inactive'";

$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_assoc($result);

echo json_encode($data);

?>