<?php
include '../includes/db_connect.php';
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
    <title>Flat Lists</title>
</head>
<body>

<h2>Flat Lists</h2>

<table border="1">
    <tr>
        <th>Flat ID</th>
        <th>Apartment Number</th>
        <th>Address</th>
        <th>Total Bedrooms</th>
    </tr>

    <?php
    // Fetch Flat Data
    $sql = "SELECT * FROM student_flats";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr>
                    <td>" . $row['flat_id'] . "</td>
                    <td>" . $row['apartment_number'] . "</td>
                    <td>" . $row['address'] . "</td>
                    <td>" . $row['total_bedrooms'] . "</td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='5'>No flats found</td></tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
