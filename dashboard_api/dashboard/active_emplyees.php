<?php

header("Content-Type: application/json");

include "../../config/db_connect.php";

$sql = "SELECT COUNT(*) AS active_employees
        FROM employees
        WHERE Status = 'Active'";

$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_assoc($result);

echo json_encode($data);

?>