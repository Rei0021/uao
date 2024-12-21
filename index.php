<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the University Accommodation Management System</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="navigator">
<h2>Welcome to the University Accommodation Management System</h2>
<p>Use the links below to navigate:</p>

<ul>
    <li><a href="pages/list_students.php">Student List</a></li>
    <li><a href="pages/list_course.php">Course Related</a></li>
    <li><a href="pages/list_staffs.php">Staffs</a></li>
    <li><a href="pages/list_halls.php">Halls of Residence</a></li>
    <li><a href="pages/list_flats.php">Student Flats</a></li>
    <li><a href="pages/avail_rooms.php">Available Rooms</a></li>
    <li><a href="pages/list_rooms.php">Room Assignments</a></li>
    <li><a href="pages/list_ls_invc.php">Lease and Invoice</a></li>
</ul>

<?php include 'includes/footer.php'; ?>
</body>
</html>
