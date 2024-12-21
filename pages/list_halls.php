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
    <title>Hall Lists</title>
</head>
<body>

<h2>Hall Lists</h2>

<table border="1">
    <tr>    
        <th>Hall ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Phone Number</th>
        <th>Staff ID</th>
    </tr>

    <?php
    // Fetch Hall Data
    $sql = "SELECT * FROM halls_of_residence";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr>
                    <td>" . $row['hall_id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['address'] . "</td>
                    <td>" . $row['phone_no'] . "</td>
                    <td>" . $row['staff_id'] . "</td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='6'>No halls found</td></tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
