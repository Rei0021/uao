


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <style>
    h2, h4, h3 { 
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

// Delete Course Logic
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