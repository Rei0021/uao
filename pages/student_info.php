<?php
include '../includes/db_connect.php';
include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student Information</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
</head>
<body>

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
</form>
</div>

<?php
// Add Student Info Logic
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
        echo "<tr>
                <td colspan='9'>No students found</td>
            </tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
