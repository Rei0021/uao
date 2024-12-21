
<style>
    .mini-tab {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        width: 300px ;
        border-radius: 5px;
        position: absolute;
        top: 58%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .mini-tab a {
        text-decoration: none;
        margin: 0 10px;
        font-size: 1rem;
        color: #f1485b;
        transition: color 0.1s ease, border-bottom 0.1s ease;
        padding-bottom: 2px;
    }

    .mini-tab a:hover {
        color: #333;
        border-bottom: 2px solid #f1485b;
    }

    .ms {
        text-align: center;
    }
</style>

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

<h2 class="ms">Manage Staffs</h2>

<!-- Tabs or mini nav-->
<nav class="mini-tab">
    <a href="?type=resi">Residence Staff</a> |
    <a href="?type=advsr">Advisers</a>
</nav>

<?php
    $type = $_GET['type'] ?? 'resi'; // Default to residence staff
    if ($type === 'resi') {
        include 'staff_resi.php';
    } else {
        include 'staff_advsr.php';
    }
?>

<?php include '../includes/footer.php'; ?>