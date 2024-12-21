<?php
include '../includes/db_connect.php';
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Next-of-Kin</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
</head>
<body>

<h2>Manage Students</h2>

<div class="form-container">
<h3>Next-of-kin Form</h3>

<!-- Form to Add Next-of-kin -->
<form action="" method="post">
    <fieldset>
        <legend>Add Next-of-kin</legend>
        <label for="bannerNum">Banner Number:</label>
        <input type="text" name="bannerNum" placeholder="Enter Banner Number" required>
        <br><br>
        <label for="name">Full Name:</label>
        <input type="text" name="name" placeholder="Enter Full Name" required>
        <br><br>
        <label for="relationship">Relationship:</label>
        <input type="text" name="relationship" placeholder="Enter Relationship" required>
        <br><br>
        <label for="address">Address:</label>
        <input type="text" name="address" placeholder="(street, city, postcode)" required>
        <br><br>
        <label for="contactNo">Contact Number:</label>
        <input type="text" name="contactNo" placeholder="Enter Number" required>
        <br><br>
        <button type="submit">Add</button>
        <br><br>
        <a href="students.php" class="mini-tab">Go Back</a>
    </fieldset>
</form>
</div>

<?php
// Add Next-of-kin Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bannerNum = $_POST['bannerNum'];
    $name = $_POST['name'];
    $rs = $_POST['relationship'];
    $address = $_POST['address'];
    $contact = $_POST['contactNo'];

    $sql = "INSERT INTO next_of_kin (banner_number, name, relationship,
            address, contact_phone) VALUES ('$bannerNum', '$name', '$rs',
            '$address', '$contact')";

    if ($conn->query($sql) === TRUE) {
        echo "Next-of-kin added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch Next-of-kin Data
$sql = "SELECT s.banner_number AS student_id, s.last_name AS lname,
        nok.name, nok.relationship, nok.address, nok.contact_phone
        FROM next_of_kin nok
        JOIN students s ON s.banner_number = nok.banner_number";
$result = $conn->query($sql);

// Delete Next-of-kin Logic
if (isset($_GET['delete'])) {
    $bannerNum = $_GET['delete'];
    $sql = "DELETE FROM next_of_kin WHERE banner_number = '$bannerNum'";

    if ($conn->query($sql) === TRUE) {
        echo "Next-of-kin deleted successfully!";
        header("Location: students.php");
    } else {
        echo "Error deleting record" . $conn->error;
    }
}
?>

<br><hr>

<h4>Next-of-kin List</h4>

<table border="1">
    <th>Banner Number</th>
    <th>Student's Family Name</th>
    <th>Name</th>
    <th>Relationship</th>
    <th>Address</th>
    <th>Mobile Number</th>
    <th>Actions</th>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['student_id'] . "</td> 
                    <td>" . $row['lname'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['relationship'] . "</td>
                    <td>" . $row['address'] . "</td>
                    <td>" . $row['contact_phone'] . "</td>
                    <td>
                        <a href='?type=nok&edit=" . $row['student_id'] . "'>Edit</a>
                        <a href='?next_of_kin&delete=" . $row['student_id'] . "'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr>
                <td colspan='8'>No next-of-kin found</td>
            </tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
