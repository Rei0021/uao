<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include '../includes/db_connect.php';
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
    <title>Manage Staffs</title>
</head>
<body>

<h2 class="mc-cont">Manage Staffs</h2>

<!-- Tabs or mini nav-->
<div class="mini-tab">
<nav>
    <a href="?type=resi">Residence Staff</a> |
    <a href="?type=advsr">Advisers</a>
</nav>
</div>

<?php
$type = $_GET['type'] ?? 'resi'; // Default to residence staff
if ($type === 'resi') {
    include 'staff_resi.php';
} else {
    include 'staff_advsr.php';
}
?>



<?php include '../includes/footer.php'; ?>
</body>
</html>
