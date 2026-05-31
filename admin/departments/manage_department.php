<?php

include '../../config/db_connect.php';
include '../../includes/session_check.php';

$sql = "SELECT * FROM departments ORDER BY DepartmentID DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Departments</title>
</head>
<body>

<h2>Manage Departments</h2>

<a href="add_department.php">Add New Department</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Department Name</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

    <td><?php echo $row['DepartmentID']; ?></td>

    <td><?php echo $row['DepartmentName']; ?></td>

    <td>

        <a href="edit_department.php?id=<?php echo $row['DepartmentID']; ?>">
            Edit
        </a>

        |

        <a href="delete_department.php?id=<?php echo $row['DepartmentID']; ?>">
            Delete
        </a>

    </td>

</tr>

<?php } ?>

</table>

</body>
</html>