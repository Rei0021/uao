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
    <title>Room Lists</title>
</head>
<body>

<h2>Room Lists</h2>

<table border="1">
    <tr>
        <th>Place Number</th>
        <th>Room Number</th>
        <th>Monthly Rent</th>
        <th>Room Type</th>
        <th>Hall Name</th>
        <th>Apartment Number</th>
    </tr>

    <?php
    // Fetch Room Data
    $sql = "SELECT r.place_number, r.room_number, r.monthly_rent,
            r.room_type, hr.name AS hall_id, sf.apartment_number AS flat_id
            FROM ((rooms r
            JOIN halls_of_residence hr ON r.hall_id = hr.hall_id)
            JOIN student_flats sf ON r.flat_id = sf.flat_id)";
    $result = $conn->query($sql);

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
