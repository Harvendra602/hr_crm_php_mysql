<?php

header("Content-Type: application/json");

include "../../config/db_connect.php";

$sql = "SELECT * FROM departments";

$result = mysqli_query($conn, $sql);

$departments = [];

while($row = mysqli_fetch_assoc($result)){
    $departments[] = $row;
}

echo json_encode($departments);

?>