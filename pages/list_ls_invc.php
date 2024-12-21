<?php
    include '../includes/db_connect.php';
    include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <style>
    h2{ 
        text-align: center;
    }
    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #34495e;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }
    </style>
    
</body>
</html>


<?php
// Fetch Lease Data
    $sql_ls = "SELECT l.lease_number, l.lease_duration, s.banner_number AS student_id,
    s.first_name AS fname, s.last_name AS lname, r.place_number AS placeNum, 
    r.room_number AS roomNum, r.room_type AS rType, l.start_date, l.end_date FROM ((leases l 
    JOIN students s ON l.banner_number = s.banner_number)
    JOIN rooms r ON l.place_number = r.place_number)";
    $result_ls = $conn->query($sql_ls);

// Fetch Invoice Data
    $sql_invc = "SELECT i.invoice_number, l.lease_number AS leaseNum, i.semester,
    i.payment_due, s.last_name AS lname, s.first_name AS fname, s.banner_number AS bannerNum,
    r.place_number AS placeNum, r.room_number AS roomNum, r.room_type AS rType, i.payment_date,
    i.payment_method, i.first_date_reminder, i.second_date_reminder
    FROM (((invoices i JOIN leases l ON i.lease_number = l.lease_number)
    JOIN students s ON i.banner_number = s.banner_number)
    JOIN rooms r ON i.place_number = r.place_number)";
    $result_invc = $conn->query($sql_invc);
?>

<h2>Lease Lists</h2>

<table border="1">
    <tr>
        <th>Lease ID</th>
        <th>Lease Duration</th>
        <th>Banner Number</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Place Number</th>
        <th>Room Number</th>
        <th>Room Type</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>

    <?php
        if ($result_ls->num_rows > 0) {
            while ($row = $result_ls->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['lease_number'] . "</td>
                        <td>" . $row['lease_duration'] . "</td>
                        <td>" . $row['student_id'] . "</td>
                        <td>" . $row['fname'] . "</td>
                        <td>" . $row['lname'] . "</td>
                        <td>" . $row['placeNum'] . "</td>
                        <td>" . $row['roomNum'] . "</td>
                        <td>" . $row['rType'] . "</td>
                        <td>" . $row['start_date'] . "</td>
                        <td>" . $row['end_date'] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No leases found</td></tr>";
        }
    ?>
</table>

<br><hr>

<h2>Invoice Lists</h2>

<table border="1">
    <tr>
        <th>Invoice ID</th>
        <th>Lease Number</th>
        <th>Semester</th>
        <th>Payment Due</th>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Banner Number</th>
        <th>Place Number</th>
        <th>Room Number</th>
        <th>Room Type</th>
        <th>Payment Date</th>
        <th>Payment Method</th>
        <th>First Date Reminder</th>
        <th>Second Date Reminder</th>
    </tr>

    <?php
        if ($result_invc->num_rows > 0) {
            while ($row = $result_invc->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['invoice_number'] . "</td>
                        <td>" . $row['leaseNum'] . "</td>
                        <td>" . $row['semester'] . "</td>
                        <td>" . $row['payment_due'] . "</td>
                        <td>" . $row['lname'] . "</td>
                        <td>" . $row['fname'] . "</td>
                        <td>" . $row['bannerNum'] . "</td>
                        <td>" . $row['placeNum'] . "</td>
                        <td>" . $row['roomNum'] . "</td>
                        <td>" . $row['rType'] . "</td>
                        <td>" . $row['payment_date'] . "</td>
                        <td>" . $row['payment_method'] . "</td>
                        <td>" . $row['first_date_reminder'] . "</td>
                        <td>" . $row['second_date_reminder'] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='13'>No invoices found</td></tr>";
        }
    ?>
</table>

<?php include '../includes/footer.php'; ?>