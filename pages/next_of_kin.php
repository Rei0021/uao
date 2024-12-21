<?php
    include '../includes/db_connect.php';
    include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <style>
    h2, h4 { 
        text-align: center;
    }
    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #34495e;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .form-container {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        text-align: center;
    }
    h3 {
        margin-bottom: 20px;
        color: #333;
        font-size: 24px;
        font-weight: bold;
    }

    form fieldset {
        border: none;
        padding: 0;
        margin: 0;
    }

    form legend {
        font-size: 18px;
        margin-bottom: 10px;
        font-weight: bold;
        color: #555;
        text-align: left;
    }

    form label {
        display: block;
        margin-bottom: 5px;
        color: #555;
        text-align: left;
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="date"],
    form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }

    form button {
        width: 100%;
        padding: 10px;
        background-color: #f1485b;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    form button:hover {
        color: #f1485b;
        background-color: white;
      
    }

    nav {
        margin-top: 20px;
    }

    nav a {
        text-decoration: none;
        color: #007bff;
        font-size: 14px;
        margin: 0 5px;
        
    }

    nav a:hover {
        color: #f1485b;
    }

    .title-cont1, .title-cont2 {
        text-align: center;
    }

    .formbutton {
    padding: 10px 20px;
    background-color: #34495e;
    color: white;
    text-align: center;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 10px;
    cursor: pointer;
    transition: background-color 0.3s;
    }

    .formbutton:hover {
        background-color: #f1485b;
    }


    </style>
    
</body>
</html>

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
        <a href="students.php" class="formbutton">Go Back</a>
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
            // Display a message if no students are found
            echo "<tr>
                    <td colspan='8'>No next-of-kin found</td>
                </tr>";
        }
    ?>
</table>

<?php include '../includes/footer.php'; ?>