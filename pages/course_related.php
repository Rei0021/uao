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

<h2>Manage Courses</h2>

<!-- Tabs or mini nav-->
 <nav>
    <a href="?type=crs">Course</a> |
    <a href="?type=nstrctr">Instructor</a>
 </nav>

<?php
    $type = $_GET['type'] ?? 'crs'; // Default to courses
    if ($type === 'crs') {
        include 'courses.php';
    } else {
        include 'instructors.php';
    }
?>

<?php include '../includes/footer.php'; ?>