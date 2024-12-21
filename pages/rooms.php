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
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
</head>
<body>

<h2>Manage Rooms</h2>
<div class="form-container">
<h3>Room Form</h3>

<!-- Add Room Form -->
<form action="" method="post">
    <fieldset>
        <legend>Add Rooms</legend>
        <label for="place_number">Place Number:</label>
        <input type="text" name="place_number" placeholder="Enter Place Number" required>
        <br><br>
        <label for="room_number">Room Number:</label>
        <input type="text" name="room_number" placeholder="Enter Room Number" required>
        <br><br>
        <label for="monthly_rent">Monthly Rent:</label>
        <input type="text" name="monthly_rent" placeholder="Enter Monthly Rent" required>
        <br><br>
        <label for="room_type">Room Type:</label>
        <input type="text" name="room_type" placeholder="Hall/Flat" required>
        <br><br>
        <label for="hall_id">Hall</label>
        <select name="hall_id">
            <option value="">Select Hall</option>
            <?php
            // Fetch halls to populate dropdown
            $sql = "SELECT * FROM halls_of_residence";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['hall_id'] . "'>
                " . $row['name'] . "</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="flat_id">Flat</label>
        <select name="flat_id">
            <option value="">Select Flat</option>
            <?php
            // Fetch flats to populate dropdown
            $sql = "SELECT * FROM student_flats";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['flat_id'] . "'>
                " . $row['apartment_number'] . "</option>";
            }
            ?>
        </select>
        <br><br>
        <button type="submit">Add Room</button>        
    </fieldset>
</form>
        </div>

<?php
// Add Room Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placeNum = $_POST['place_number'];
    $roomNum = $_POST['room_number'];
    $monthlyRent = $_POST['monthly_rent'];
    $roomType = $_POST['room_type'];
    $hall_id = $_POST['hall_id'];
    $flat_id = $_POST['flat_id'];

    $sql = "INSERT INTO rooms (place_number, room_number, monthly_rent,
    room_type, hall_id, flat_id) VALUES ('$placeNum', '$roomNum', '$monthlyRent',
    '$roomType', '$hall_id', '$flat_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: rooms.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch Room Data
$sql = "SELECT r.place_number, r.room_number, r.monthly_rent,
        r.room_type, hr.name AS hall_id, sf.apartment_number AS flat_id
        FROM ((rooms r
        JOIN halls_of_residence hr ON r.hall_id = hr.hall_id)
        JOIN student_flats sf ON r.flat_id = sf.flat_id)";
$result = $conn->query($sql);

// Delete Room Logic
if (isset($_GET['delete'])) {
    $placeNum = $_GET['delete'];
    $sql = "DELETE FROM rooms WHERE place_number = $placeNum";

    if ($conn->query($sql) === TRUE) {
        header("Location: rooms.php");
    } else {
        echo "Error deleting record" . $conn->error;
    }
}
?>

<br><hr>

<h4>Room List</h4>

<table border="1">
    <tr>
        <th>Place Number</th>
        <th>Room Number</th>
        <th>Monthly Rent</th>
        <th>Room Type</th>
        <th>Hall Name</th>
        <th>Apartment Number</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            echo "
                <tr>
                    <td>" . $row['place_number'] . "</td>
                    <td>" . $row['room_number'] . "</td>
                    <td>" . $row['monthly_rent'] . "</td>
                    <td>" . $row['room_type'] . "</td>
                    <td>" . $row['hall_id'] . "</td>
                    <td>" . $row['flat_id'] . "</td>
                    <td>
                        <a href='?type=room&edit=" . $row['place_number'] . "'>Edit</a>
                        <a href='?type=room&delete=" . $row['place_number'] . "'>Delete</a>
                    </td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='9'>No rooms found</td></tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
