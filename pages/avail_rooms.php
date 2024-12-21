<?php
include '../includes/db_connect.php';
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Rooms</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
</head>
<body>

<h2>Room Lists</h2>

<h4>Halls</h4>

<table border="1">
    <tr>
        <th>Place Number</th>
        <th>Room Number</th>
        <th>Monthly Rent</th>
        <th>Hall Name</th>
    </tr>

    <?php
    // Fetch Room Data for Halls
    $sql = "SELECT r.place_number, r.room_number, r.monthly_rent,
            hr.name AS hall_id
            FROM rooms r
            JOIN halls_of_residence hr ON r.hall_id = hr.hall_id
            WHERE r.room_type = 'Hall'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            echo "
                <tr>
                    <td>" . $row['place_number'] . "</td>
                    <td>" . $row['room_number'] . "</td>
                    <td>" . $row['monthly_rent'] . "</td>
                    <td>" . $row['hall_id'] . "</td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='5'>No rooms found</td></tr>";
    }
    ?>
</table>

<br><hr>

<h4>Flats</h4>

<table border="1">
    <tr>
        <th>Place Number</th>
        <th>Room Number</th>
        <th>Monthly Rent</th>
        <th>Apartment Number</th>
    </tr>

    <?php
    // Fetch Room Data for Flats
    $sql = "SELECT r.place_number, r.room_number, r.monthly_rent,
            sf.apartment_number AS flat_id
            FROM rooms r
            JOIN student_flats sf ON r.flat_id = sf.flat_id
            WHERE r.room_type = 'Flat'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            echo "
                <tr>
                    <td>" . $row['place_number'] . "</td>
                    <td>" . $row['room_number'] . "</td>
                    <td>" . $row['monthly_rent'] . "</td>
                    <td>" . $row['flat_id'] . "</td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='4'>No rooms found</td></tr>";
    }
    ?>
</table>

<br><hr>

<h4>Total Amount</h4>

<table border="1">
    <tr>
        <th>Total Rent Value</th>
    </tr>

    <?php
    // Fetch Total Amount Data
    $sql = "SELECT SUM(monthly_rent) AS total_rent FROM rooms";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            echo "
                <tr>
                    <td>" . $row['total_rent'] . "</td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='1'>No total amount found</td></tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
