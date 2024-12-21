<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_connect.php';
include '../includes/header.php';

// Fetch Room Data for Editing if edit parameter is set
$roomData = null;
if (isset($_GET['edit'])) {
    $placeNum = $_GET['edit'];
    $sql = "SELECT r.place_number, r.room_number, r.monthly_rent, r.room_type, r.hall_id, r.flat_id 
            FROM rooms r 
            WHERE r.place_number = '$placeNum'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $roomData = $result->fetch_assoc();
    } else {
        echo "Room not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="assets/styles.css">
    <script>
        // Function to toggle visibility of the form
        function toggleForm() {
            const formContainer = document.getElementById('edit-form-container');
            if (formContainer.style.display === "none" || formContainer.style.display === "") {
                formContainer.style.display = "block";
            } else {
                formContainer.style.display = "none";
            }
        }
    </script>
</head>
<body>

<h2>Manage Rooms</h2>

<!-- Button to toggle the form display -->
<div class="mini-tab">
    <nav>
        <a href="javascript:void(0);" onclick="toggleForm()">Manage Room</a>
    </nav>
</div>



<div class="form-container" id="edit-form-container" style="display: <?php echo isset($roomData) ? 'block' : 'none'; ?>;">
    <h3><?php echo isset($roomData) ? 'Edit Room' : 'Add Room'; ?></h3>
    <form action="" method="post">
        <fieldset>
            <legend><?php echo isset($roomData) ? 'Edit Room' : 'Add Room'; ?></legend>
            <label for="place_number">Place Number:</label>
            <input type="text" name="place_number" value="<?php echo isset($roomData) ? $roomData['place_number'] : ''; ?>" placeholder="Enter Place Number" required>
            <br><br>
            <label for="room_number">Room Number:</label>
            <input type="text" name="room_number" value="<?php echo isset($roomData) ? $roomData['room_number'] : ''; ?>" placeholder="Enter Room Number" required>
            <br><br>
            <label for="monthly_rent">Monthly Rent:</label>
            <input type="text" name="monthly_rent" value="<?php echo isset($roomData) ? $roomData['monthly_rent'] : ''; ?>" placeholder="Enter Monthly Rent" required>
            <br><br>
            <label for="room_type">Room Type:</label>
            <input type="text" name="room_type" value="<?php echo isset($roomData) ? $roomData['room_type'] : ''; ?>" placeholder="Hall/Flat" required>
            <br><br>
            <label for="hall_id">Hall</label>
            <select name="hall_id">
                <option value="">Select Hall</option>
                <?php
                $sql = "SELECT * FROM halls_of_residence";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $selected = (isset($roomData) && $roomData['hall_id'] == $row['hall_id']) ? 'selected' : '';
                    echo "<option value='" . $row['hall_id'] . "' $selected>" . $row['name'] . "</option>";
                }
                ?>
            </select>
            <br><br>
            <label for="flat_id">Flat</label>
            <select name="flat_id">
                <option value="">Select Flat</option>
                <?php
                $sql = "SELECT * FROM student_flats";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $selected = (isset($roomData) && $roomData['flat_id'] == $row['flat_id']) ? 'selected' : '';
                    echo "<option value='" . $row['flat_id'] . "' $selected>" . $row['apartment_number'] . "</option>";
                }
                ?>
            </select>
            <br><br>
            <button type="submit" name="submit"><?php echo isset($roomData) ? 'Update Room' : 'Add Room'; ?></button>        
        </fieldset>
    </form>
</div>

<?php
// Add or Edit Room Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placeNum = $_POST['place_number'];
    $roomNum = $_POST['room_number'];
    $monthlyRent = $_POST['monthly_rent'];
    $roomType = $_POST['room_type'];
    $hall_id = $_POST['hall_id'];
    $flat_id = $_POST['flat_id'];

    if (isset($roomData)) {
        // Update existing room
        $sql = "UPDATE rooms SET room_number='$roomNum', monthly_rent='$monthlyRent', 
                room_type='$roomType', hall_id='$hall_id', flat_id='$flat_id' 
                WHERE place_number='$placeNum'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Room updated successfully!');</script>";
            header("Location: rooms.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Add new room
        $sql = "INSERT INTO rooms (place_number, room_number, monthly_rent, 
                room_type, hall_id, flat_id) VALUES ('$placeNum', '$roomNum', '$monthlyRent', 
                '$roomType', '$hall_id', '$flat_id')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Room added successfully!');</script>";
            header("Location: rooms.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch Room Data
$sql = "SELECT r.place_number, r.room_number, r.monthly_rent, r.room_type, hr.name AS hall_id, sf.apartment_number AS flat_id
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
                        <a href='?edit=" . $row['place_number'] . "'>Edit</a>
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
