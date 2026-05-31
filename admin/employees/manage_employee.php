<?php
include '../../config/db_connect.php';

$sql = "SELECT * FROM employees";
$result = mysqli_query($conn, $sql);
?>

<h2>Manage Employees</h2>

<a href="add_employee.php">Add New Employee</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Designation</th>
    <th>Salary</th>
    <th>Joining Date</th>
    <th>Status</th>
    <th>Department ID</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

    <td><?php echo $row['EmployeeID']; ?></td>

    <td><?php echo $row['FullName']; ?></td>

    <td><?php echo $row['Email']; ?></td>

    <td><?php echo $row['Phone']; ?></td>

    <td><?php echo $row['Designation']; ?></td>

    <td><?php echo $row['Salary']; ?></td>

    <td><?php echo $row['JoiningDate']; ?></td>

    <td><?php echo $row['Status']; ?></td>

    <td><?php echo $row['DepartmentID']; ?></td>

    <td>

        <a href="view_employee.php?id=<?php echo $row['EmployeeID']; ?>">
            View
        </a>

        |

        <a href="edit_employee.php?id=<?php echo $row['EmployeeID']; ?>">
            Edit
        </a>

        |

        <a href="delete_employee.php?id=<?php echo $row['EmployeeID']; ?>">
            Delete
        </a>

    </td>

</tr>

<?php } ?>

</table>