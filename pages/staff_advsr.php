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

<h4>Adviser Form</h4>

<!-- Add Adviser Form -->
<form action="" method="post">
    <fieldset>
        <legend>Add Adviser</legend>
        <label for="fullName">Full Name:</label>
        <input type="text" name="fullName" placeholder="Enter Full Name" required>
        <br><br>
        <label for="position">Position:</label>
        <input type="text" name="position" placeholder="Enter Position" required>
        <br><br>
        <label for="deptName">Department Name:</label>
        <input type="text" name="deptName" placeholder="Enter Dept. Name" required>
        <br><br>
        <label for="internal_phone_no">Internal Phone:</label>
        <input type="text" name="internal_phone_no" placeholder="Enter Phone Number" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter Email" required>
        <br><br>
        <label for="roomNum">Room Number:</label>
        <input type="text" name="roomNum" placeholder="Enter Room Number" required>
        <br><br>
        <button type="submit">Add Adviser</button>
    </fieldset>
</form>

<?php
// Add Adviser Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $position = $_POST['position'];
    $deptName = $_POST['deptName'];
    $internal_phone_no = $_POST['internal_phone_no'];
    $email = $_POST['email'];
    $roomNum = $_POST['roomNum'];

    $sql = "INSERT INTO advisers (full_name, position, department_name,
    internal_phone_no, email, room_number) VALUES ('$fullName', '$position',
    '$deptName', '$internal_phone_no', '$email', '$roomNum')";

    if ($conn->query($sql) === TRUE) {
        header("Location: staffs.php?type=advsr");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

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

<h4>List</h4>

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
        while ($row = $result->fetch_assoc()){
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

<?php include '../includes/footer.php'; ?>
</body>
</html>
