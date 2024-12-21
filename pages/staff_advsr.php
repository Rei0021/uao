<?php
include '../includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
    <title>Manage Advisers</title>
</head>
<body>

<h3>Manage Advisers</h3>
<div class="form-container">
<h4>Adviser Form</h4>

<?php
// Check if we need to edit an adviser
if (isset($_GET['edit'])) {
    $adviser_id = $_GET['edit'];
    $sql = "SELECT * FROM advisers WHERE adviser_id = '$adviser_id'";
    $result = $conn->query($sql);
    $adviser = $result->fetch_assoc();
}

// Handle form submission for adding or editing an adviser
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $position = $_POST['position'];
    $deptName = $_POST['deptName'];
    $internal_phone_no = $_POST['internal_phone_no'];
    $email = $_POST['email'];
    $roomNum = $_POST['roomNum'];

    if (isset($_GET['edit'])) {
        // If we are editing an existing adviser, update their info
        $adviser_id = $_GET['edit'];
        $sql = "UPDATE advisers SET full_name='$fullName', position='$position', 
                department_name='$deptName', internal_phone_no='$internal_phone_no', 
                email='$email', room_number='$roomNum' WHERE adviser_id='$adviser_id'";
    } else {
        // Otherwise, add a new adviser
        $sql = "INSERT INTO advisers (full_name, position, department_name, 
                internal_phone_no, email, room_number) VALUES 
                ('$fullName', '$position', '$deptName', '$internal_phone_no', 
                '$email', '$roomNum')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: staffs.php?type=advsr");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Form to Add/Edit Adviser -->
<form action="" method="post">
    <fieldset>
        <legend><?php echo isset($_GET['edit']) ? "Edit" : "Add"; ?> Adviser</legend>
        <label for="fullName">Full Name:</label>
        <input type="text" name="fullName" placeholder="Enter Full Name" value="<?php echo isset($adviser['full_name']) ? $adviser['full_name'] : ''; ?>" required>
        <br><br>
        <label for="position">Position:</label>
        <input type="text" name="position" placeholder="Enter Position" value="<?php echo isset($adviser['position']) ? $adviser['position'] : ''; ?>" required>
        <br><br>
        <label for="deptName">Department Name:</label>
        <input type="text" name="deptName" placeholder="Enter Dept. Name" value="<?php echo isset($adviser['department_name']) ? $adviser['department_name'] : ''; ?>" required>
        <br><br>
        <label for="internal_phone_no">Internal Phone:</label>
        <input type="text" name="internal_phone_no" placeholder="Enter Phone Number" value="<?php echo isset($adviser['internal_phone_no']) ? $adviser['internal_phone_no'] : ''; ?>" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter Email" value="<?php echo isset($adviser['email']) ? $adviser['email'] : ''; ?>" required>
        <br><br>
        <label for="roomNum">Room Number:</label>
        <input type="text" name="roomNum" placeholder="Enter Room Number" value="<?php echo isset($adviser['room_number']) ? $adviser['room_number'] : ''; ?>" required>
        <br><br>
        <button type="submit"><?php echo isset($_GET['edit']) ? "Update" : "Add"; ?> Adviser</button>
    </fieldset>
</form>
</div>

<?php
// Fetch Adviser Data
$sql = "SELECT * FROM advisers";
$result = $conn->query($sql);

// Delete Adviser Logic
if (isset($_GET['delete'])) {
    $adviser_id = $_GET['delete'];
    $sql = "DELETE FROM advisers WHERE adviser_id = $adviser_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: staffs.php?type=advsr");
    } else {
        echo "Error deleting record" . $conn->error;
    }
}
?>

<br><hr>

<h4>List of Advisers</h4>

<table border="1">
    <tr>
        <th>Adviser ID</th>
        <th>Full Name</th>
        <th>Position</th>
        <th>Department Name</th>
        <th>Internal Phone Number</th>
        <th>Email</th>
        <th>Room Number</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr>
                    <td>" . $row['adviser_id'] . "</td>
                    <td>" . $row['full_name'] . "</td>
                    <td>" . $row['position'] . "</td>
                    <td>" . $row['department_name'] . "</td>
                    <td>" . $row['internal_phone_no'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['room_number'] . "</td>
                    <td>
                        <a href='?type=advsr&edit=" . $row['adviser_id'] . "'>Edit</a>
                        <a href='?type=advsr&delete=" . $row['adviser_id'] . "'>Delete</a>
                    </td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='8'>No advisers found</td></tr>";
    }
    ?>
</table>


</body>
</html>
