<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
    <title>Manage Student Flats</title>
</head>
<body>

<h3>Manage Student Flats</h3>

<h4>Flat Form</h4>

<!-- Add Flat Form -->
<form action="" method="post">
    <fieldset>
        <legend>Add Flat</legend>
        <label for="apartment_number">Apartment Number:</label>
        <input type="text" name="apartment_number" placeholder=" Enter Apartment Number" required>
        <br><br>
        <label for="address">Address:</label>
        <input type="text" name="address" placeholder="Enter Address" required>
        <br><br>
        <label for="total_bedrooms">Total Bedrooms:</label>
        <input type="number" name="total_bedrooms" placeholder="Total Bedrooms" required>
        <br><br>
        <button type="submit">Add Flat</button>
        <br><br><br>
        <a href="acco_flats_inspect.php">Add Inspection</a>
    </fieldset>
</form>

<?php
// Add Flat Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apartment_number = $_POST['apartment_number'];
    $address = $_POST['address'];
    $total_bedrooms = $_POST['total_bedrooms'];

    $sql = "INSERT INTO student_flats (apartment_number, address, total_bedrooms)
    VALUES ('$apartment_number', '$address', $total_bedrooms)";

    if ($conn->query($sql) === TRUE) {
        header("Location: accommodation.php?type=flat");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch Flat Data
$sql_flat = "SELECT * FROM student_flats";
$result_flat = $conn->query($sql_flat);

// Delete Flat Logic
if (isset($_GET['delete'])) {
    $flat_id = $_GET['delete'];
    $sql = "DELETE FROM student_flats WHERE flat_id = $flat_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: accommodation.php?type=flat");
    } else {
        echo "Error deleting record" . $conn->error;
    }
}

// Fetch Inspection Data
$sql_inspect = "SELECT i.inspection_id, rs.last_name AS inspctrLname,
                sf.apartment_number AS apartmentNum, i.inspection_date,
                i.satisfactory_condition, i.comments
                FROM ((inspections i 
                JOIN residence_staff rs ON i.staff_id = rs.staff_id)
                JOIN student_flats sf ON i.flat_id = sf.flat_id)";
$resul_inspect = $conn->query($sql_inspect);

// Delete Inspection Logic
if (isset($_GET['delete'])) {
    $inspection_id = $_GET['delete'];
    $sql = "DELETE FROM inspections WHERE inspection_id = $inspection_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: accommodation.php?type=flat");
    } else {
        echo "Error deleting record" . $conn->error;
    }
}
?>

<br><hr>

<h4>Flat List</h4>

<table border="1">
    <tr>
        <th>Flat ID</th>
        <th>Apartment Number</th>
        <th>Address</th>
        <th>Total Bedrooms</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result_flat->num_rows > 0) {
        while ($row = $result_flat->fetch_assoc()) {
            echo "
                <tr>
                    <td>" . $row['flat_id'] . "</td>
                    <td>" . $row['apartment_number'] . "</td>
                    <td>" . $row['address'] . "</td>
                    <td>" . $row['total_bedrooms'] . "</td>
                    <td>
                        <a href='?type=flat&edit=" . $row['flat_id'] . "'>Edit</a>
                        <a href='?type=flat&delete=" . $row['flat_id'] . "'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No flats found</td></tr>";
    }
    ?>
</table>

<br><br>

<h4>Inspection List</h4>

<table border="1">
    <tr>
        <th>Inspection ID</th>
        <th>Staff Inspector</th>
        <th>Apartment Number</th>
        <th>Inspection Date</th>
        <th>Satisfactory Condition</th>
        <th>Additional Comments</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($resul_inspect->num_rows > 0) {
        while ($row = $resul_inspect->fetch_assoc()) {
            echo "
                <tr>
                    <td>" . $row['inspection_id'] . "</td>
                    <td>" . $row['inspctrLname'] . "</td>
                    <td>" . $row['apartmentNum'] . "</td>
                    <td>" . $row['inspection_date'] . "</td>
                    <td>" . $row['satisfactory_condition'] . "</td>
                    <td>" . $row['comments'] . "</td>
                    <td>
                        <a href='?type=flatInspect&edit=" . $row['inspection_id'] . "'>Edit</a>
                        <a href='?type=flatInspect&delete=" . $row['inspection_id'] . "'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No inspection found</td></tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
