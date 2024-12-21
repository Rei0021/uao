<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leases</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
</head>
<body>

<h3>Manage Leases</h3>

<h4>Lease Form</h4>

<!-- Add Lease Form -->
<form action="" method="post">
    <fieldset>
        <legend>Add Lease</legend>
        <label for="leaseDuration">Lease Duration:</label>
        <input type="text" name="leaseDuration" placeholder="(Whole Year, First/Second Semester)" required>
        <br><br>
        <label for="bannerNum">Banner Number:</label>
        <input type="text" name="bannerNum" placeholder="Enter Banner Number" required>
        <br><br>
        <label for="placeNumber">Place Number:</label>
        <input type="text" name="placeNumber" placeholder="Enter Place Number" required>
        <br><br>
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" placeholder="Start Date">
        <br><br>
        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" placeholder="End Date">
        <br><br>
        <button type="submit">Add Lease</button>
    </fieldset>
</form>

<?php
// Add Lease Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $duration = $_POST['leaseDuration'];
    $bannerNum = $_POST['bannerNum'];
    $placeNum = $_POST['placeNumber'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $sql = "INSERT INTO leases (lease_duration, banner_number, place_number,
            start_date, end_date) VALUES ('$duration', '$bannerNum', '$placeNum',
            '$startDate', '$endDate')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: transaction.php?type=lease");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

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
    $leaseNum = $_GET['delete'];
    $sql = "DELETE FROM leases WHERE lease_number = '$leaseNum'";

    if ($conn->query($sql) === TRUE) {
        header("Location: transaction.php?type=lease");
    } else {
        echo "Error deleting record" . $conn->error;
    }
}
?>

<br><hr>

<h4>Lease List</h4>
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
        echo "<tr><td colspan='8'>No leases found</td></tr>";
    }
    ?>
</table>
</body>
</html>
