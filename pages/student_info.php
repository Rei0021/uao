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

<h2>Manage Students</h2>

<div class="form-container">
<h3>Student Information Form</h3>

<!-- Form to Add New Student Info -->
<form action="" method="post">
    <fieldset>
        <legend>Add Student Information</legend>
        <label for="bannerNum">Banner Number:</label>
        <input type="text" name="bannerNum" placeholder="Enter Banner Number" required>
        <br><br>
        <label for="homeAddress">Home Address:</label>
        <input type="text" name="homeAddress" placeholder="(street, city, postcode)">
        <br><br>
        <label for="mobile_phone">Mobile Phone:</label>
        <input type="text" name="mobile_phone" placeholder="Enter Mobile Number">
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter Email">
        <br><br>
        <label for="dateBirth">Date of Birth:</label>
        <input type="date" name="dateBirth" placeholder="Date of Birth">
        <br><br>
        <label for="gender">Gender:</label>
        <input type="text" name="gender" placeholder="Male/Female/Other">
        <br><br>
        <label for="nationality">Nationality:</label>
        <input type="text" name="nationality" placeholder="Nationality">
        <br><br>
        <button type="submit">Add info</button>
        <br><br>
        <a href="students.php" class="formbutton">Go Back</a>
        </fieldset>
    </fieldset>
</form>
</div>

<?php
// Add Student InfoLogic
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bannerNo = $_POST['bannerNum'];
        $homeAdd = $_POST['homeAddress'];
        $phoneNo = $_POST['mobile_phone'];
        $email = $_POST['email'];
        $dob = $_POST['dateBirth'];
        $gender = $_POST['gender'];
        $nationality = $_POST['nationality'];

        $sql = "INSERT INTO student_info (banner_number, home_address,
                mobile_phone, email, date_of_birth, gender, nationality)
                VALUES ('$bannerNo', '$homeAdd', '$phoneNo', '$email', '$dob',
                '$gender', '$nationality')";

        if ($conn->query($sql) === TRUE) {
            echo "Student information added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

// Fetch Student Info Data
    $sql = "SELECT s.first_name AS fname, s.last_name AS lname,
            sf.home_address, sf.mobile_phone, sf.email, sf.date_of_birth,
            sf.gender, sf.nationality, s.banner_number AS student_id
            FROM student_info sf 
            JOIN students s ON s.banner_number = sf.banner_number";
    $result = $conn->query($sql);    

// Delete Student Info Logic
    if (isset($_GET['delete'])) {
        $bannerNum = $_GET['delete'];
        $sql = "DELETE FROM student_info WHERE banner_number = '$bannerNum'";

        if ($conn->query($sql) === TRUE) {
            echo "Student information deleted successfully!";
            header("Location: students.php");
        } else {
            echo "Error deleting record" . $conn->error;
        }
    }    
?>

<br><hr>

<h4>Student Information List</h4>

<table border="1">
    <th>First Name</th>
    <th>Last Name</th>
    <th>Home Address</th>
    <th>Mobile Number</th>
    <th>Email</th>
    <th>Date of Birth</th>
    <th>Gender</th>
    <th>Nationality</th>
    <th>Actions</th>

    <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                        <td>" . $row['fname'] . "</td> 
                        <td>" . $row['lname'] . "</td>
                        <td>" . $row['home_address'] . "</td>
                        <td>" . $row['mobile_phone'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['date_of_birth'] . "</td>
                        <td>" . $row['gender'] . "</td>
                        <td>" . $row['nationality'] . "</td>
                        <td>
                            <a href='?type=student_info&edit=" . $row['student_id'] . "'>Edit</a>
                            <a href='?student_info&delete=" . $row['student_id'] . "'>Delete</a>
                        </td>
                    </tr>";
            }
        } else {
            // Display a message if no students are found
            echo "<tr>
                    <td colspan='9'>No students found</td>
                </tr>";
        }
    ?>
</table>

<?php include '../includes/footer.php'; ?>