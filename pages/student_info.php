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

<?php
// Check if we need to edit a student
if (isset($_GET['edit'])) {
    // Fetch the current student info to pre-fill the form
    $student_id = $_GET['edit'];
    $sql = "SELECT * FROM student_info WHERE banner_number = '$student_id'";
    $result = $conn->query($sql);
    $student = $result->fetch_assoc();
} 

// Handle form submission for adding or editing student info
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bannerNo = $_POST['bannerNum'];
    $homeAdd = $_POST['homeAddress'];
    $phoneNo = $_POST['mobile_phone'];
    $email = $_POST['email'];
    $dob = $_POST['dateBirth'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];

    if (isset($_GET['edit'])) {
        // If we are editing an existing student, update the student info
        $sql = "UPDATE student_info SET home_address='$homeAdd', mobile_phone='$phoneNo', email='$email',
                date_of_birth='$dob', gender='$gender', nationality='$nationality'
                WHERE banner_number='$bannerNo'";
    } else {
        // Otherwise, add a new student
        $sql = "INSERT INTO student_info (banner_number, home_address, mobile_phone, email, date_of_birth, gender, nationality)
                VALUES ('$bannerNo', '$homeAdd', '$phoneNo', '$email', '$dob', '$gender', '$nationality')";
    }

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the list after successful add or edit
        header("Location: student_info.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Form to Add/Edit Student Info -->
<form action="" method="post">
    <fieldset>
        <legend><?php echo isset($_GET['edit']) ? "Edit" : "Add"; ?> Student Information</legend>
        <label for="bannerNum">Banner Number:</label>
        <input type="text" name="bannerNum" placeholder="Enter Banner Number" value="<?php echo isset($student['banner_number']) ? $student['banner_number'] : ''; ?>" required>
        <br><br>
        <label for="homeAddress">Home Address:</label>
        <input type="text" name="homeAddress" placeholder="(street, city, postcode)" value="<?php echo isset($student['home_address']) ? $student['home_address'] : ''; ?>">
        <br><br>
        <label for="mobile_phone">Mobile Phone:</label>
        <input type="text" name="mobile_phone" placeholder="Enter Mobile Number" value="<?php echo isset($student['mobile_phone']) ? $student['mobile_phone'] : ''; ?>">
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter Email" value="<?php echo isset($student['email']) ? $student['email'] : ''; ?>">
        <br><br>
        <label for="dateBirth">Date of Birth:</label>
        <input type="date" name="dateBirth" placeholder="Date of Birth" value="<?php echo isset($student['date_of_birth']) ? $student['date_of_birth'] : ''; ?>">
        <br><br>
        <label for="gender">Gender:</label>
        <input type="text" name="gender" placeholder="Male/Female/Other" value="<?php echo isset($student['gender']) ? $student['gender'] : ''; ?>">
        <br><br>
        <label for="nationality">Nationality:</label>
        <input type="text" name="nationality" placeholder="Nationality" value="<?php echo isset($student['nationality']) ? $student['nationality'] : ''; ?>">
        <br><br>
        <button type="submit"><?php echo isset($_GET['edit']) ? "Update Info" : "Add Info"; ?></button>
        <br><br>
        <a href="students.php" class="formbutton">Go Back</a>
    </fieldset>
</form>
</div>

<?php
// Fetch Student Info Data for the table
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
                        <a href='?edit=" . $row['student_id'] . "'>Edit</a>
                        <a href='?delete=" . $row['student_id'] . "'>Delete</a>
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
