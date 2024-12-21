<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
    <title>Manage Instructor</title>
</head>
<body>

<h3>Manage Instructor</h3>
<div class="form-container">
<h4>Instructor Form</h4>

<form action="" method="post">
    <fieldset>
        <legend>Add Instructor</legend>
        <label for="name">Full Name:</label>
        <input type="text" name="name" placeholder="Enter Name" required>
        <br><br>
        <label for="phone_no">Phone Number:</label>
        <input type="text" name="phone_no" placeholder="Enter Contact Number" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter Email" required>
        <br><br>
        <label for="instructor_room">Instructor Room:</label>
        <input type="text" name="instructor_room" placeholder="Enter Room Number" required>
        <br><br>
        <button type="submit">Add Instructor</button>
    </fieldset>
</form>
</div>

<?php
// Add Instructor Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];
    $instructor_room = $_POST['instructor_room'];

    $sql = "INSERT INTO instructors (name, phone_no, email, instructor_room)
            VALUES ('$name', '$phone_no', '$email', '$instructor_room')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Instructor added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch Instructor Data
$sql = "SELECT * FROM instructors";
$result = $conn->query($sql);

// Delete Instructor Logic
if (isset($_GET['delete'])) {
    $instructor_id = $_GET['delete'];
    $sql = "DELETE FROM instructors WHERE instructor_id = $instructor_id";

    if ($conn->query($sql) === TRUE) {
        echo "Instructor deleted successfully";
        header("Location: course_related.php?type=nstrctr");
    } else {
        echo "Error deleting record" . $conn->error;
    }
}
?>

<br><hr>

<h4>List</h4>

<table border="1">
    <tr>
        <th>Instructor ID</th>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Instructor's Room</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr>
                    <td>" . $row['instructor_id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['phone_no'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['instructor_room'] . "</td>
                    <td>
                        <a href='?type=nstrctr&edit=" . $row['instructor_id'] . "'>Edit</a>
                        <a href='?type=nstrctr&delete=" . $row['instructor_id'] . "'>Delete</a>
                    </td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='6'>No Instructor found</td></tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
