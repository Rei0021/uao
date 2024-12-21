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
    <title>Manage Courses</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
</head>
<body>

<h2 class="mc-cont">Manage Courses</h2>
<div class="mg-navbar">
<!-- Tabs or mini nav-->
 <nav>
    <a href="?type=crs">Course</a> |
    <a href="?type=nstrctr">Instructor</a>
 </nav>
</div>

<?php
$type = $_GET['type'] ?? 'crs'; // Default to courses
if ($type === 'crs') {
    include 'courses.php';
} else {
    include 'instructors.php';
}
?>

<?php include '../includes/footer.php'; ?>
</body>
</html>
