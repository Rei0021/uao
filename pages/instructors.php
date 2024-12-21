<?php
include '../includes/db_connect.php';
?>

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

<?php
// Check if we need to edit an instructor
if (isset($_GET['edit'])) {
    $instructor_id = $_GET['edit'];
    $sql = "SELECT * FROM instructors WHERE instructor_id = '$instructor_id'";
    $result = $conn->query($sql);
    $instructor = $result->fetch_assoc();
} 

// Handle form submission for adding or editing instructor info
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];
    $instructor_room = $_POST['instructor_room'];

    if (isset($_GET['edit'])) {
        // If we are editing an existing instructor, update the info
        $instructor_id = $_GET['edit'];
        $sql = "UPDATE instructors SET name='$name', phone_no='$phone_no', 
                email='$email', instructor_room='$instructor_room' 
                WHERE instructor_id='$instructor_id'";
    } else {
        // Otherwise, add a new instructor
        $sql = "INSERT INTO instructors (name, phone_no, email, instructor_room)
                VALUES ('$name', '$phone_no', '$email', '$instructor_room')";
    }

    if ($conn->query($sql) === TRUE) {
        // Redirect after successful add or edit
        header("Location: course_related.php?type=nstrctr");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Form to Add/Edit Instructor -->
<form action="" method="post">
    <fieldset>
        <legend><?php echo isset($_GET['edit']) ? "Edit" : "Add"; ?> Instructor</legend>
        <label for="name">Full Name:</label>
        <input type="text" name="name" placeholder="Enter Name" value="<?php echo isset($instructor['name']) ? $instructor['name'] : ''; ?>" required>
        <br><br>
        <label for="phone_no">Phone Number:</label>
        <input type="text" name="phone_no" placeholder="Enter Contact Number" value="<?php echo isset($instructor['phone_no']) ? $instructor['phone_no'] : ''; ?>" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter Email" value="<?php echo isset($instructor['email']) ? $instructor['email'] : ''; ?>" required>
        <br><br>
        <label for="instructor_room">Instructor Room:</label>
        <input type="text" name="instructor_room" placeholder="Enter Room Number" value="<?php echo isset($instructor['instructor_room']) ? $instructor['instructor_room'] : ''; ?>" required>
        <br><br>
        <button type="submit"><?php echo isset($_GET['edit']) ? "Update" : "Add"; ?> Instructor</button>
    </fieldset>
</form>
</div>

<?php
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

<h4>Instructor List</h4>

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
        echo "<tr><td colspan='6'>No instructors found</td></tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
