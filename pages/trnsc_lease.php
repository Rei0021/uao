<?php
include '../includes/db_connect.php';

$leaseToEdit = null; // Variable to hold the lease being edited
if (isset($_GET['edit'])) {
    $leaseId = $_GET['edit'];

    // Fetch the lease details for prefill
    $stmt = $conn->prepare("SELECT * FROM leases WHERE lease_number = ?");
    $stmt->bind_param("s", $leaseId);
    $stmt->execute();
    $leaseToEdit = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Handle Add/Update Lease Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $duration = $_POST['leaseDuration'];
    $bannerNum = $_POST['bannerNum'];
    $placeNum = $_POST['placeNumber'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    if (isset($_POST['leaseId']) && $_POST['leaseId'] !== "") {
        // Update existing lease
        $leaseId = $_POST['leaseId'];
        $stmt = $conn->prepare("UPDATE leases 
                                SET lease_duration = ?, banner_number = ?, place_number = ?, start_date = ?, end_date = ? 
                                WHERE lease_number = ?");
        $stmt->bind_param("ssssss", $duration, $bannerNum, $placeNum, $startDate, $endDate, $leaseId);
    } else {
        // Insert new lease
        $stmt = $conn->prepare("INSERT INTO leases (lease_duration, banner_number, place_number, start_date, end_date) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $duration, $bannerNum, $placeNum, $startDate, $endDate);
    }

    if ($stmt->execute()) {
        header("Location: transaction.php?type=lease");
        exit;
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leases</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>

<h3>Manage Leases</h3>
<div class="form-container">
    <h4><?php echo $leaseToEdit ? "Edit Lease" : "Add Lease"; ?></h4>

    <!-- Lease Form -->
    <form action="" method="post">
        <fieldset>
            <legend><?php echo $leaseToEdit ? "Update Lease" : "Add Lease"; ?></legend>
            <input type="hidden" name="leaseId" value="<?php echo $leaseToEdit['lease_number'] ?? ''; ?>">

            <label for="leaseDuration">Lease Duration:</label>
            <input type="text" name="leaseDuration" placeholder="(Whole Year, First/Second Semester)" 
                value="<?php echo $leaseToEdit['lease_duration'] ?? ''; ?>" required>
            <br><br>

            <label for="bannerNum">Banner Number:</label>
            <input type="text" name="bannerNum" placeholder="Enter Banner Number" 
                value="<?php echo $leaseToEdit['banner_number'] ?? ''; ?>" required>
            <br><br>

            <label for="placeNumber">Place Number:</label>
            <input type="text" name="placeNumber" placeholder="Enter Place Number" 
                value="<?php echo $leaseToEdit['place_number'] ?? ''; ?>" required>
            <br><br>

            <label for="startDate">Start Date:</label>
            <input type="date" name="startDate" 
                value="<?php echo $leaseToEdit['start_date'] ?? ''; ?>" required>
            <br><br>

            <label for="endDate">End Date:</label>
            <input type="date" name="endDate" 
                value="<?php echo $leaseToEdit['end_date'] ?? ''; ?>" required>
            <br><br>

            <button type="submit"><?php echo $leaseToEdit ? "Update Lease" : "Add Lease"; ?></button>
        </fieldset>
    </form>
</div>

<?php
// Fetch Lease Data
$sql = "SELECT l.lease_number, l.lease_duration, s.banner_number AS student_id, 
        s.first_name AS fname, s.last_name AS lname, r.place_number AS placeNum, 
        r.room_number AS roomNum, r.room_type AS rType, l.start_date, l.end_date 
        FROM ((leases l 
        JOIN students s ON l.banner_number = s.banner_number) 
        JOIN rooms r ON l.place_number = r.place_number)";
$result = $conn->query($sql);

// Delete Lease Logic
if (isset($_GET['delete'])) {
    $leaseId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM leases WHERE lease_number = ?");
    $stmt->bind_param("s", $leaseId);

    if ($stmt->execute()) {
        header("Location: transaction.php?type=lease");
        exit;
    } else {
        echo "<p style='color: red;'>Error deleting record: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>

<br><hr>
<h4>Lease List</h4>
<div class="table-container">
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
            <th>Actions</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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
                        <td>
                            <a href='?type=lease&edit=" . $row['lease_number'] . "'>Edit</a>
                            <a href='?type=lease&delete=" . $row['lease_number'] . "'>Delete</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No leases found</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
