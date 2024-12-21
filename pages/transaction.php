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
    <title>Manage Transaction</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
</head>
<body>

<h2>Manage Transaction</h2>

<!-- Tabs or mini nav-->
<nav>
    <a href="?type=lease">Lease</a> |
    <a href="?type=invoice">Invoice</a>
</nav>

<?php
$type = $_GET['type'] ?? 'lease'; // Default to leases
if ($type === 'lease') {
    include 'trnsc_lease.php';
} else {
    include 'trnsc_invoice.php';
}
?>

<?php include '../includes/footer.php'; ?>
</body>
</html>
