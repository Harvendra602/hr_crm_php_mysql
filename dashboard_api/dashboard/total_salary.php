<?php

header("Content-Type: application/json");

include "../../config/db_connect.php";

$sql = "SELECT SUM(Salary) AS total_salary FROM employees";

$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_assoc($result);

echo json_encode($data);

?>