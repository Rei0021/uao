<?php
include '../includes/db_connect.php';

$invoiceToEdit = null; // Variable to hold the invoice being edited
if (isset($_GET['edit'])) {
    $invoiceId = $_GET['edit'];

    // Fetch the invoice details for prefill
    $stmt = $conn->prepare("SELECT * FROM invoices WHERE invoice_number = ?");
    $stmt->bind_param("s", $invoiceId);
    $stmt->execute();
    $invoiceToEdit = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Add or Update Invoice Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $leaseNum = $_POST['leaseNum'];
    $sem = $_POST['semester'];
    $payDue = $_POST['paymentDue'];
    $bannerNum = $_POST['bannerNum'];
    $placeNum = $_POST['placeNum'];
    $payDate = $_POST['paymentDate'];
    $payMethod = $_POST['paymentMethod'];
    $firstDateReminder = $_POST['firstDateReminder'];
    $secondDateReminder = $_POST['secondDateReminder'];

    if (isset($_POST['invoiceId']) && $_POST['invoiceId'] !== "") {
        // Update existing invoice
        $invoiceId = $_POST['invoiceId'];
        $stmt = $conn->prepare("UPDATE invoices 
                                SET lease_number = ?, semester = ?, payment_due = ?, 
                                    banner_number = ?, place_number = ?, payment_date = ?, 
                                    payment_method = ?, first_date_reminder = ?, second_date_reminder = ?
                                WHERE invoice_number = ?");
        $stmt->bind_param(
            "ssssssssss",
            $leaseNum,
            $sem,
            $payDue,
            $bannerNum,
            $placeNum,
            $payDate,
            $payMethod,
            $firstDateReminder,
            $secondDateReminder,
            $invoiceId
        );
    } else {
        // Insert new invoice
        $stmt = $conn->prepare("INSERT INTO invoices (lease_number, semester, payment_due, 
                                banner_number, place_number, payment_date, payment_method, 
                                first_date_reminder, second_date_reminder) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sssssssss",
            $leaseNum,
            $sem,
            $payDue,
            $bannerNum,
            $placeNum,
            $payDate,
            $payMethod,
            $firstDateReminder,
            $secondDateReminder
        );
    }

    if ($stmt->execute()) {
        header("Location: transaction.php?type=invoice");
        exit;
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
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
    $invoiceId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM invoices WHERE invoice_number = ?");
    $stmt->bind_param("s", $invoiceId);

    if ($stmt->execute()) {
        header("Location: transaction.php?type=invoice");
        exit;
    } else {
        echo "<p style='color: red;'>Error deleting record: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>

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
<div class="form-container">
    <h4><?php echo $invoiceToEdit ? "Edit Invoice" : "Add Invoice"; ?></h4>

    <!-- Add/Edit Invoice Form -->
    <form action="" method="post">
        <fieldset>
            <legend><?php echo $invoiceToEdit ? "Update Invoice" : "Add Invoice"; ?></legend>
            <input type="hidden" name="invoiceId" value="<?php echo $invoiceToEdit['invoice_number'] ?? ''; ?>">

            <label for="leaseNum">Lease Number:</label>
            <input type="text" name="leaseNum" placeholder="Enter Lease ID" 
                value="<?php echo $invoiceToEdit['lease_number'] ?? ''; ?>" required>
            <br><br>

            <label for="semester">Semester:</label>
            <input type="text" name="semester" placeholder="Enter Semester" 
                value="<?php echo $invoiceToEdit['semester'] ?? ''; ?>" required>
            <br><br>

            <label for="paymentDue">Payment Due:</label>
            <input type="text" name="paymentDue" placeholder="Enter Due Amount" 
                value="<?php echo $invoiceToEdit['payment_due'] ?? ''; ?>" required>
            <br><br>

            <label for="bannerNum">Banner Number:</label>
            <input type="text" name="bannerNum" placeholder="Enter Banner Number" 
                value="<?php echo $invoiceToEdit['banner_number'] ?? ''; ?>" required>
            <br><br>

            <label for="placeNum">Place Number:</label>
            <input type="text" name="placeNum" placeholder="Enter Place Number" 
                value="<?php echo $invoiceToEdit['place_number'] ?? ''; ?>" required>
            <br><br>

            <label for="paymentDate">Payment Date:</label>
            <input type="date" name="paymentDate" 
                value="<?php echo $invoiceToEdit['payment_date'] ?? ''; ?>">
            <br><br>

            <label for="paymentMethod">Payment Method:</label>
            <input type="text" name="paymentMethod" placeholder="(Check, Cash, Visa, Other)" 
                value="<?php echo $invoiceToEdit['payment_method'] ?? ''; ?>" required>
            <br><br>

            <label for="firstDateReminder">1st Reminder:</label>
            <input type="date" name="firstDateReminder" 
                value="<?php echo $invoiceToEdit['first_date_reminder'] ?? ''; ?>">
            <br><br>

            <label for="secondDateReminder">2nd Reminder:</label>
            <input type="date" name="secondDateReminder" 
                value="<?php echo $invoiceToEdit['second_date_reminder'] ?? ''; ?>">
            <br><br>

            <button type="submit"><?php echo $invoiceToEdit ? "Update Invoice" : "Add Invoice"; ?></button>
        </fieldset>
    </form>
</div>

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
