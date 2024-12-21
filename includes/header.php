

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Accommodation Management System</title>
</head>

<link rel="stylesheet" href="/uao/assets/styles.css">


<body>

<header>
<div class="header-title">
    <h1>University Accommodation Management System</h1>
</div>
    <nav class="Navbar">
        <ul>
            <li><a href="/uao/index.php">Home</a></li>
            <li><a href="/uao/pages/students.php">Manage Students</a></li>
            <li><a href="/uao/pages/course_related.php">Manage Courses</a></li>
            <li><a href="/uao/pages/staffs.php">Manage Staffs</a></li>
            <li><a href="/uao/pages/accommodation.php">Manage Accommodation</a></li>
            <li><a href="/uao/pages/rooms.php">Manage Rooms</a></li>
            <li><a href="/uao/pages/transaction.php">Manage Transaction</a></li>
            <li><a href="/uao/pages/reports.php">Reports</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="/uao/pages/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/uao/pages/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
     <!-- Include JavaScript file -->
     <script src="../assets/js/students.js"></script>
</header>
</body>
</html>