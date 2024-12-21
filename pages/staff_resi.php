<?php
include '../includes/db_connect.php';
?>

<h3>Manage Residence Staff</h3>
<div class="form-container">
<h4>Staff Form</h4>

<?php
// Check if we need to edit a staff member
if (isset($_GET['edit'])) {
    $staff_id = $_GET['edit'];
    $sql = "SELECT * FROM residence_staff WHERE staff_id = '$staff_id'";
    $result = $conn->query($sql);
    $staff = $result->fetch_assoc();
} 

// Handle form submission for adding or editing staff info
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $homeAddress = $_POST['homeAddress'];
    $date = $_POST['dateBirth'];
    $gender = $_POST['gender'];
    $position = $_POST['position'];
    $location = $_POST['location'];

    if (isset($_GET['edit'])) {
        // If we are editing an existing staff, update the info
        $staff_id = $_GET['edit'];
        $sql = "UPDATE residence_staff SET first_name='$firstName', last_name='$lastName', 
                email='$email', home_address='$homeAddress', date_of_birth='$date', 
                gender='$gender', position='$position', location='$location' 
                WHERE staff_id='$staff_id'";
    } else {
        // Otherwise, add a new staff
        $sql = "INSERT INTO residence_staff (first_name, last_name, email, home_address, 
                date_of_birth, gender, position, location) VALUES 
                ('$firstName', '$lastName', '$email', '$homeAddress', '$date', '$gender', 
                '$position', '$location')";
    }

    if ($conn->query($sql) === TRUE) {
        // Redirect after successful add or edit
        header("Location: staffs.php?type=resi");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Form to Add/Edit Staff -->
<form action="" method="post">
    <fieldset>
        <legend><?php echo isset($_GET['edit']) ? "Edit" : "Add"; ?> Staff</legend>
        <label for="fname">First Name:</label>
        <input type="text" name="fname" placeholder="Enter First Name" value="<?php echo isset($staff['first_name']) ? $staff['first_name'] : ''; ?>" required>
        <br><br>
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" placeholder="Enter Last Name" value="<?php echo isset($staff['last_name']) ? $staff['last_name'] : ''; ?>" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter Email" value="<?php echo isset($staff['email']) ? $staff['email'] : ''; ?>" required>
        <br><br>
        <label for="homeAddress">Home Address:</label>
        <input type="text" name="homeAddress" placeholder="(street, city, postcode)" value="<?php echo isset($staff['home_address']) ? $staff['home_address'] : ''; ?>" required>
        <br><br>
        <label for="dateBirth">Date of Birth:</label>
        <input type="date" name="dateBirth" value="<?php echo isset($staff['date_of_birth']) ? $staff['date_of_birth'] : ''; ?>">
        <br><br>
        <label for="gender">Gender:</label>
        <input type="text" name="gender" placeholder="Male/Female/Other" value="<?php echo isset($staff['gender']) ? $staff['gender'] : ''; ?>" required>
        <br><br>
        <label for="position">Position:</label>
        <input type="text" name="position" placeholder="(ex. Hall Manager, Administrative Assistant, Cleaner)" value="<?php echo isset($staff['position']) ? $staff['position'] : ''; ?>" required>
        <br><br>
        <label for="location">Location:</label>
        <input type="text" name="location" placeholder="(ex. Residence Office or Hall)" value="<?php echo isset($staff['location']) ? $staff['location'] : ''; ?>" required>
        <br><br>
        <button type="submit"><?php echo isset($_GET['edit']) ? "Update" : "Add"; ?> Staff</button>
    </fieldset>
</form>
</div>

<?php
// Fetch Staff Data
$sql = "SELECT * FROM residence_staff";
$result = $conn->query($sql);

// Delete Staff Logic
if (isset($_GET['delete'])) {
    $staff_id = $_GET['delete'];
    $sql = "DELETE FROM residence_staff WHERE staff_id = $staff_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect after deletion
        header("Location: staffs.php?type=resi");
        exit();
    } else {
        echo "Error deleting record" . $conn->error;
    }
}
?>

<br><hr>

<h4>Staff List</h4>

<table border="1">
    <tr>
        <th>Staff ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Home Address</th>
        <th>Date of Birth</th>
        <th>Gender</th>
        <th>Position</th>
        <th>Location</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr>
                    <td>" . $row['staff_id'] . "</td>
                    <td>" . $row['first_name'] . "</td>
                    <td>" . $row['last_name'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['home_address'] . "</td>
                    <td>" . $row['date_of_birth'] . "</td>
                    <td>" . $row['gender'] . "</td>
                    <td>" . $row['position'] . "</td>
                    <td>" . $row['location'] . "</td>
                    <td>
                        <a href='?type=resi&edit=" . $row['staff_id'] . "'>Edit</a>
                        <a href='?type=resi&delete=" . $row['staff_id'] . "'>Delete</a>
                    </td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='10'>No staff found</td></tr>";
    }
    ?>
</table>

</body>
</html>
