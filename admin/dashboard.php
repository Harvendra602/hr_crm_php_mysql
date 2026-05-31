<?php
session_start();

include '../config/db_connect.php';

/*
|--------------------------------------------------------------------------
| Login Check
|--------------------------------------------------------------------------
*/

if(!isset($_SESSION['admin_logged_in'])){

    header("Location: ../auth/login.php");
    exit();

}

$total_employees = 0;
$total_departments = 0;
$recent_employees = [];

$employee_count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees");
if($employee_count){
    $total_employees = (int) mysqli_fetch_assoc($employee_count)['total'];
}

$department_count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM departments");
if($department_count){
    $total_departments = (int) mysqli_fetch_assoc($department_count)['total'];
}

$recent_sql = "SELECT e.EmployeeID, e.FullName, e.Email, e.Designation, e.Status,
                      d.DepartmentName
               FROM employees e
               LEFT JOIN departments d ON e.DepartmentID = d.DepartmentID
               ORDER BY e.EmployeeID DESC
               LIMIT 5";

$recent_result = mysqli_query($conn, $recent_sql);
if($recent_result){
    while($row = mysqli_fetch_assoc($recent_result)){
        $recent_employees[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR CRM Dashboard</title>

    <style>

        :root {
            --bg: #eef1f6;
            --surface: #ffffff;
            --text: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.06);
            --shadow-md: 0 8px 24px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 16px 40px rgba(15, 23, 42, 0.12);
            --radius: 18px;
            --radius-sm: 12px;
            --transition: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            --blue: linear-gradient(145deg, #3b82f6 0%, #1d4ed8 100%);
            --green: linear-gradient(145deg, #22c55e 0%, #15803d 100%);
            --orange: linear-gradient(145deg, #f97316 0%, #ea580c 100%);
            --blue-soft: #eff6ff;
            --green-soft: #f0fdf4;
            --orange-soft: #fff7ed;
            --primary: #2563eb;
            --danger: #ef4444;
            --danger-hover: #dc2626;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
            min-height: 100vh;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--surface);
            border-right: 1px solid var(--border);
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-sm);
            flex-shrink: 0;
        }

        .sidebar-brand {
            padding: 0 8px 28px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 24px;
        }

        .sidebar-brand h1 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .sidebar-brand span {
            display: block;
            margin-top: 4px;
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: var(--radius-sm);
            transition: background var(--transition), color var(--transition);
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: var(--blue-soft);
            color: var(--primary);
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 24px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            background: var(--danger);
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 600;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .logout-btn:hover {
            background: var(--danger-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Main content */
        .main-content {
            flex: 1;
            padding: 32px 36px 48px;
            overflow-x: hidden;
        }

        .page-header {
            margin-bottom: 32px;
        }

        .page-header h2 {
            margin: 0;
            font-size: 1.65rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .page-header p {
            margin: 6px 0 0;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Stat cards */
        .stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 28px;
        }

        .stat-card {
            position: relative;
            padding: 28px 30px;
            border-radius: var(--radius);
            color: white;
            overflow: hidden;
            transition: transform var(--transition), box-shadow var(--transition);
            box-shadow: var(--shadow-md);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -15%;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card--employees {
            background: var(--blue);
        }

        .stat-card--departments {
            background: var(--green);
        }

        .stat-card-inner {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-card h3 {
            margin: 0 0 10px;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            opacity: 0.92;
        }

        .stat-card .number {
            font-size: 2.85rem;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -0.03em;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.22);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            backdrop-filter: blur(4px);
        }

        /* Recent employees — orange card */
        .recent-section {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            margin-bottom: 28px;
            overflow: hidden;
            border: 1px solid rgba(249, 115, 22, 0.15);
            transition: transform var(--transition), box-shadow var(--transition);
        }

        .recent-section:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .recent-header {
            background: var(--orange);
            color: white;
            padding: 22px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .recent-header h2 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .recent-header .badge {
            background: rgba(255, 255, 255, 0.22);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .recent-body {
            padding: 24px 28px 28px;
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
        }

        .recent-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .recent-table th,
        .recent-table td {
            padding: 14px 18px;
            text-align: left;
        }

        .recent-table th {
            background: var(--orange-soft);
            color: #9a3412;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid #fed7aa;
        }

        .recent-table td {
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }

        .recent-table tbody tr {
            transition: background var(--transition);
        }

        .recent-table tbody tr:last-child td {
            border-bottom: none;
        }

        .recent-table tbody tr:hover {
            background: var(--orange-soft);
        }

        .view-link {
            display: inline-block;
            color: #ea580c;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 6px 14px;
            border-radius: 8px;
            background: var(--orange-soft);
            transition: background var(--transition), color var(--transition);
        }

        .view-link:hover {
            background: #f97316;
            color: white;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-badge--active {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge--inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-message {
            color: var(--text-muted);
            margin: 0;
            padding: 36px;
            text-align: center;
            background: var(--orange-soft);
            border-radius: var(--radius-sm);
            border: 1px dashed #fdba74;
        }

        /* Quick actions */
        .section-title {
            margin: 0 0 18px;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text);
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .card {
            background: var(--surface);
            padding: 26px 28px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: #cbd5e1;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .card-icon--employees {
            background: var(--blue-soft);
        }

        .card-icon--departments {
            background: var(--green-soft);
        }

        .card h2 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .card a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            text-decoration: none;
            color: var(--text);
            font-size: 0.9rem;
            font-weight: 500;
            background: #f8fafc;
            border-radius: var(--radius-sm);
            border: 1px solid transparent;
            transition: background var(--transition), border-color var(--transition), color var(--transition);
        }

        .card--employees a:hover {
            background: var(--blue-soft);
            border-color: #bfdbfe;
            color: var(--primary);
        }

        .card--departments a:hover {
            background: var(--green-soft);
            border-color: #bbf7d0;
            color: #15803d;
        }

        .card a::before {
            content: '→';
            font-size: 0.85rem;
            opacity: 0.45;
        }

        .card a:hover::before {
            opacity: 1;
        }

        /* Mobile top bar (hidden on desktop) */
        .mobile-topbar {
            display: none;
        }

        @media (max-width: 900px) {
            .admin-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--border);
                padding: 20px;
            }

            .sidebar-brand {
                padding-bottom: 16px;
                margin-bottom: 16px;
            }

            .sidebar-nav {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .sidebar-footer {
                margin-top: 16px;
            }

            .logout-btn {
                width: auto;
                display: inline-flex;
            }

            .main-content {
                padding: 24px 20px 36px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .dashboard {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 540px) {
            .stat-card .number {
                font-size: 2.25rem;
            }

            .recent-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 18px 20px;
            }

            .recent-body {
                padding: 16px;
            }

            .recent-table th,
            .recent-table td {
                padding: 10px 12px;
                font-size: 0.82rem;
            }
        }

    </style>

</head>

<body>

<div class="admin-layout">

<aside class="sidebar">

    <div class="sidebar-brand">
        <h1>HR CRM</h1>
        <span>Admin Panel</span>
    </div>

    <nav class="sidebar-nav">
        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="employees/manage_employee.php">Employees</a>
        <a href="departments/manage_department.php">Departments</a>
    </nav>

    <div class="sidebar-footer">
        <a class="logout-btn" href="../auth/logout.php">Logout</a>
    </div>

</aside>

<main class="main-content">

<div class="page-header">
    <h2>Dashboard</h2>
    <p>Overview of your organization</p>
</div>

<div class="stats">

    <div class="stat-card stat-card--employees">
        <div class="stat-card-inner">
            <div>
                <h3>Total Employees</h3>
                <div class="number"><?php echo $total_employees; ?></div>
            </div>
            <div class="stat-icon" aria-hidden="true">👥</div>
        </div>
    </div>

    <div class="stat-card stat-card--departments">
        <div class="stat-card-inner">
            <div>
                <h3>Total Departments</h3>
                <div class="number"><?php echo $total_departments; ?></div>
            </div>
            <div class="stat-icon" aria-hidden="true">🏢</div>
        </div>
    </div>

</div>

<div class="recent-section">

    <div class="recent-header">
        <h2>Recently Added Employees</h2>
        <span class="badge"><?php echo count($recent_employees); ?> recent</span>
    </div>

    <div class="recent-body">

    <?php if(count($recent_employees) > 0){ ?>

    <div class="table-wrap">
    <table class="recent-table">

        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>

        <?php foreach($recent_employees as $employee){
            $is_active = strtolower($employee['Status']) === 'active';
        ?>

        <tr>
            <td><?php echo htmlspecialchars($employee['FullName']); ?></td>
            <td><?php echo htmlspecialchars($employee['Email']); ?></td>
            <td><?php echo htmlspecialchars($employee['Designation']); ?></td>
            <td><?php echo htmlspecialchars($employee['DepartmentName'] ?? '—'); ?></td>
            <td>
                <span class="status-badge <?php echo $is_active ? 'status-badge--active' : 'status-badge--inactive'; ?>">
                    <?php echo htmlspecialchars($employee['Status']); ?>
                </span>
            </td>
            <td>
                <a class="view-link" href="employees/view_employee.php?id=<?php echo (int) $employee['EmployeeID']; ?>">
                    View
                </a>
            </td>
        </tr>

        <?php } ?>

        </tbody>

    </table>
    </div>

    <?php } else { ?>

    <p class="empty-message">No employees added yet. Use the quick actions below to get started.</p>

    <?php } ?>

    </div>

</div>

<h2 class="section-title">Quick Actions</h2>

<div class="dashboard">

    <div class="card card--employees">

        <div class="card-header">
            <div class="card-icon card-icon--employees" aria-hidden="true">👥</div>
            <h2>Employees</h2>
        </div>

        <div class="card-links">
            <a href="employees/add_employee.php">Add Employee</a>
            <a href="employees/manage_employee.php">Manage Employees</a>
        </div>

    </div>

    <div class="card card--departments">

        <div class="card-header">
            <div class="card-icon card-icon--departments" aria-hidden="true">🏢</div>
            <h2>Departments</h2>
        </div>

        <div class="card-links">
            <a href="departments/add_department.php">Add Department</a>
            <a href="departments/manage_department.php">Manage Departments</a>
        </div>

    </div>

</div>

</main>

</div>

</body>
</html>