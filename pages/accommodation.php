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

<h2>Manage Accommodation</h2>

<!-- Tabs or mini nav-->
<nav>
    <a href="?type=hall">Halls of Residence</a> |
    <a href="?type=flat">Student Flats</a>
</nav>

<?php
    $type = $_GET['type'] ?? 'hall'; // Default to halls of residence
    if ($type === 'hall') {
        include 'acco_halls.php';
    } else {
        include 'acco_flats.php';
    }
?>

<?php include '../includes/footer.php'; ?>