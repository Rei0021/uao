<?php
include '../includes/db_connect.php';
include '../includes/header.php';

// Check if we're editing a student
if (isset($_GET['edit'])) {
    $bannerNum = $_GET['edit'];

    // Fetch the student data to populate the form
    $sql = "SELECT * FROM students WHERE banner_number = '$bannerNum'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found!";
        exit();
    }
}

// Add or Update Student Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $category = $_POST['category'];
    $specialNeeds = $_POST['specialNeeds'];
    $addComments = $_POST['comments'];
    $currentStat = $_POST['status'];
    $major = $_POST['major'];
    $minor = $_POST['minor'];
    $adviser_id = $_POST['adviser_id'];
    $courseNum = $_POST['course_number'];

    if (isset($_GET['edit'])) {
        // Update student record
        $sql = "UPDATE students SET first_name='$fname', last_name='$lname', category='$category', special_needs='$specialNeeds',
                additional_comments='$addComments', current_status='$currentStat', major='$major', minor='$minor',
                adviser_id='$adviser_id', course_number='$courseNum' WHERE banner_number = '$bannerNum'";

        if ($conn->query($sql) === TRUE) {
            header("Location: students.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Insert new student record
        $sql = "INSERT INTO students (first_name, last_name, category, special_needs,
                additional_comments, current_status, major, minor, adviser_id, course_number)
                VALUES ('$fname', '$lname', '$category', '$specialNeeds', '$addComments',
                '$currentStat', '$major', '$minor', '$adviser_id', '$courseNum')";

        if ($conn->query($sql) === TRUE) {
            header("Location: students.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<h2 class="title-cont1">Manage Students</h2>

<div class="form-container">
 <h3><?php echo isset($_GET['edit']) ? 'Edit Student' : 'Add Student'; ?></h3>

<!-- Form to Add or Edit Student -->
<form action="" method="post">
    <fieldset>
        <legend><?php echo isset($_GET['edit']) ? 'Edit Student' : 'Add Student'; ?></legend>
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" placeholder="Enter First Name" value="<?php echo isset($student) ? $student['first_name'] : ''; ?>" required>
        <br><br>
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" placeholder="Enter Last Name" value="<?php echo isset($student) ? $student['last_name'] : ''; ?>" required>
        <br><br>
        <label for="category">Student Category:</label>
        <input type="text" name="category" placeholder="(1-4 yr)Undergrad/Graduate" value="<?php echo isset($student) ? $student['category'] : ''; ?>" required>
        <br><br>
        <label for="specialNeeds">Special Needs:</label>
        <input type="text" name="specialNeeds" placeholder="Enter special needs if any" value="<?php echo isset($student) ? $student['special_needs'] : ''; ?>" required>
        <br><br>
        <label for="comments">Additional Comments:</label>
        <input type="text" name="comments" placeholder="Add Comment" value="<?php echo isset($student) ? $student['additional_comments'] : ''; ?>" required>
        <br><br>
        <label for="status">Current Status:</label>
        <input type="text" name="status" placeholder="Placed/Waiting" value="<?php echo isset($student) ? $student['current_status'] : ''; ?>" required>
        <br><br>
        <label for="major">Major:</label>
        <input type="text" name="major" placeholder="Enter Major" value="<?php echo isset($student) ? $student['major'] : ''; ?>" required>
        <br><br>
        <label for="minor">Minor:</label>
        <input type="text" name="minor" placeholder="Enter Minor" value="<?php echo isset($student) ? $student['minor'] : ''; ?>" required>
        <br><br>
        <label for="adviser_id">Adviser:</label>
        <select name="adviser_id" required>
            <option value="">Select Adviser</option>
            <?php
            // Fetch advisers to populate dropdown
            $sql = "SELECT * FROM advisers";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['adviser_id'] . "' " . (isset($student) && $student['adviser_id'] == $row['adviser_id'] ? 'selected' : '') . ">
                " . $row['full_name'] . "</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="course_number">Course Department:</label>
        <select name="course_number" required>
            <option value="">Select Department</option>
            <?php
            // Fetch courses to populate dropdown
            $sql = "SELECT DISTINCT department_name, course_number FROM courses";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['course_number'] . "' " . (isset($student) && $student['course_number'] == $row['course_number'] ? 'selected' : '') . ">
                " . $row['department_name'] . "</option>";
            }
            ?>
        </select>
        <br><br>
        <button type="submit"><?php echo isset($_GET['edit']) ? 'Update Student' : 'Add Student'; ?></button>
        <br><br>
    </fieldset>
</form>   
</div>

<div class="mini-tab">
    <nav>
        <a href="student_info.php">Add Student Information</a> |
        <a href="next_of_kin.php">Add Next-of-Kin</a>
    </nav> 
</div>

<?php
// Fetch Student Data (for the list)
$sql = "SELECT s.banner_number, s.first_name, s.last_name, s.category,
        s.special_needs, s.additional_comments, s.current_status, s.major, s.minor,
        a.full_name AS adviser_id, c.department_name AS course_number
        FROM ((students s
    JOIN advisers a ON s.adviser_id = a.adviser_id)
    JOIN courses c ON s.course_number = c.course_number)";
$result = $conn->query($sql);

// Delete Student Logic
if (isset($_GET['delete'])) {
    $bannerNum = $_GET['delete'];
    $sql = "DELETE FROM students WHERE banner_number = '$bannerNum'";

    if ($conn->query($sql) === TRUE) {
        header("Location: students.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<br><hr>

<h4 class="title-cont2">Student List</h4>

<table border="1">
    <tr>
        <th>Banner Number</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Student Category</th>
        <th>Special Needs</th>
        <th>Additional Comments</th>
        <th>Current Status</th>
        <th>Major</th>
        <th>Minor</th>
        <th>Adviser</th>
        <th>Department</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr>
                    <td>" . $row['banner_number'] . "</td>
                    <td>" . $row['first_name'] . "</td>
                    <td>" . $row['last_name'] . "</td>
                    <td>" . $row['category'] . "</td>
                    <td>" . $row['special_needs'] . "</td>
                    <td>" . $row['additional_comments'] . "</td>
                    <td>" . $row['current_status'] . "</td>
                    <td>" . $row['major'] . "</td>
                    <td>" . $row['minor'] . "</td>
                    <td>" . $row['adviser_id'] . "</td>
                    <td>" . $row['course_number'] . "</td>
                    <td>
                        <a href='?edit=" . $row['banner_number'] . "'>Edit</a>
                        <a href='?delete=" . $row['banner_number'] . "'>Delete</a>
                    </td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='12'>No Students found</td></tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
