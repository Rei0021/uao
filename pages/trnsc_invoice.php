<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Invoices</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
</head>
<body>

<h3>Manage Invoices</h3>

<h4>Invoice Form</h4>

<!-- Add Invoice Form -->
<form action="" method="post">
    <fieldset>
        <legend>Add Invoice</legend>
        <label for="leaseNum">Lease Number:</label>
        <input type="text" name="leaseNum" placeholder="Enter Lease ID" required>
        <br><br>
        <label for="semester">Semester:</label>
        <input type="text" name="semester" placeholder="Enter Semester" required>
        <br><br>
        <label for="paymentDue">Payment Due:</label>
        <input type="text" name="paymentDue" placeholder="Enter Due Amount" required>
        <br><br>
        <label for="bannerNum">Banner Number:</label>
        <input type="text" name="bannerNum" placeholder="Enter Banner Number" required>
        <br><br>
        <label for="placeNum">Place Number:</label>
        <input type="text" name="placeNum" placeholder="Enter Place Number" required>
        <br><br>
        <label for="paymentDate">Payment Date:</label>
        <input type="date" name="paymentDate" placeholder="Payment Date">
        <br><br>
        <label for="paymentMethod">Payment Method:</label>
        <input type="text" name="paymentMethod" placeholder="(Check, Cash, Visa, Other)" required>
        <br><br>
        <label for="firstDateReminder">1st Reminder:</label>
        <input type="date" name="firstDateReminder" placeholder="1st Reminder">
        <br><br>
        <label for="secondDateReminder">2nd Reminder:</label>
        <input type="date" name="secondDateReminder" placeholder="2nd Reminder">
        <br><br>
        <button type="submit">Add Invoice</button>
    </fieldset>
</form>

<?php
// Add Invoice Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $leaseNum = $_POST['leaseNum'];
    $sem = $_POST['semester'];
    $payDue = $_POST['paymentDue'];
    $bannerNum = $_POST['bannerNum'];
    $placeNum = $_POST['placeNum'];
    $payDate = $_POST['paymentDate'];
    $payMethod = $_POST['paymentMethod'];
    $first_date_reminder = $_POST['firstDateReminder'];
    $second_date_reminder = $_POST['secondDateReminder'];

    $sql = "INSERT INTO invoices (lease_number, semester, payment_due,
            banner_number, place_number, payment_date, payment_method,
            first_date_reminder, second_date_reminder) VALUES ('$leaseNum',
            '$sem', '$payDue', '$bannerNum', '$placeNum', '$payDate', '$payMethod',
            '$first_date_reminder', '$second_date_reminder')";

    if ($conn->query($sql) === TRUE) {
        header("Location: transaction.php?type=invoice");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch Invoice Data
$sql = "SELECT i.invoice_number, l.lease_number AS leaseNum, i.semester,
i.payment_due, s.last_name AS lname, s.first_name AS fname, s.banner_number AS bannerNum,
r.place_number AS placeNum, r.room_number AS roomNum, r.room_type AS rType, i.payment_date,
i.payment_method, i.first_date_reminder, i.second_date_reminder
FROM (((invoices i JOIN leases l ON i.lease_number = l.lease_number)
JOIN students s ON i.banner_number = s.banner_number)
JOIN rooms r ON i.place_number = r.place_number)";
$result = $conn->query($sql);

// Delete Invoice Logic
if (isset($_GET['delete'])) {
    $invoiceNum = $_GET['delete'];
    $sql = "DELETE FROM invoices WHERE invoice_number = '$invoiceNum'";

    if ($conn->query($sql) === TRUE) {
        header("Location: transaction.php?type=invoice");
    } else {
        echo "Error deleting record" . $conn->error;
    }
}
?>

<br><hr>

<h4>Invoice List</h4>
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
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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
                    <td>
                        <a href='?type=invoice&edit=" . $row['invoice_number'] . "'>Edit</a>
                        <a href='?type=invoice&delete=" . $row['invoice_number'] . "'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='15'>No invoices found</td></tr>";
    }
    ?>
</table>
</body>
</html>
