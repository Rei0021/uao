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
    <title>Manage Accommodation</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
</head>
<body>
    
<h2 class="mc-cont">Manage Accommodation</h2>

<!-- Tabs or mini nav-->
<div class="mini-tab">
<nav>
    <a href="?type=hall">Halls of Residence</a> |
    <a href="?type=flat">Student Flats</a>
</nav>
</div>

<?php
$type = $_GET['type'] ?? 'hall'; // Default to halls of residence
if ($type === 'hall') {
    include 'acco_halls.php';
} else {
    include 'acco_flats.php';
}
?>

<?php include '../includes/footer.php'; ?>
</body>
</html>
