<?php
include '../includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
    <title>Manage Course</title>
</head>
<body>

<h3>Manage Course</h3>
<div class="form-container">
<h4>Course Form</h4>

<?php
// Check if we need to edit a course
if (isset($_GET['edit'])) {
    $course_number = $_GET['edit'];
    $sql = "SELECT * FROM courses WHERE course_number = '$course_number'";
    $result = $conn->query($sql);
    $course = $result->fetch_assoc();
} 

// Handle form submission for adding or editing course info
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseNum = $_POST['course_number'];
    $courseTitle = $_POST['course_title'];
    $instructor_id = $_POST['instructor_id'];
    $dept_name = $_POST['dept_name'];

    if (isset($_GET['edit'])) {
        // If we are editing an existing course, update the info
        $sql = "UPDATE courses SET course_title='$courseTitle', instructor_id='$instructor_id', 
                department_name='$dept_name' WHERE course_number='$courseNum'";
    } else {
        // Otherwise, add a new course
        $sql = "INSERT INTO courses (course_number, course_title, instructor_id, department_name)
                VALUES ('$courseNum', '$courseTitle', '$instructor_id', '$dept_name')";
    }

    if ($conn->query($sql) === TRUE) {
        // Redirect after successful add or edit
        header("Location: course_related.php?type=crs");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Form to Add/Edit Course -->
<form action="" method="post">
    <fieldset>
        <legend><?php echo isset($_GET['edit']) ? "Edit" : "Add"; ?> Course</legend>
        <label for="course_number">Course ID:</label>
        <input type="text" name="course_number" placeholder="Enter Course Number" value="<?php echo isset($course['course_number']) ? $course['course_number'] : ''; ?>" required>
        <br><br>
        <label for="course_title">Course Title:</label>
        <input type="text" name="course_title" placeholder="Course Title" value="<?php echo isset($course['course_title']) ? $course['course_title'] : ''; ?>" required>
        <br><br>
        <label for="instructor_id">Instructor:</label>
        <select name="instructor_id">
            <option value="">Select Instructor</option>
            <?php
            // Fetch instructor to populate dropdown
            $sql = "SELECT * FROM instructors";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $selected = isset($course['instructor_id']) && $course['instructor_id'] == $row['instructor_id'] ? 'selected' : '';
                echo "<option value='" . $row['instructor_id'] . "' $selected>" . $row['name'] . "</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="dept_name">Department Name:</label>
        <input type="text" name="dept_name" placeholder="Department Name" value="<?php echo isset($course['department_name']) ? $course['department_name'] : ''; ?>" required>
        <br><br>
        <button type="submit"><?php echo isset($_GET['edit']) ? "Update" : "Add"; ?> Course</button>
    </fieldset>
</form>
</div>

<?php
// Fetch Course Data
$sql = "SELECT c.course_number, c.course_title, i.name AS instructor_name,
        c.department_name
        FROM courses c
        JOIN instructors i ON c.instructor_id = i.instructor_id";
$result = $conn->query($sql);

// Delete Course Logic
if (isset($_GET['delete'])) {
    $courseNum = $_GET['delete'];
    $sql = "DELETE FROM courses WHERE course_number = $courseNum";

    if ($conn->query($sql) === TRUE) {
        echo "Course deleted successfully";
        header("Location: course_related.php?type=crs");
    } else {
        echo "Error deleting record" . $conn->error;
    }
}
?>

<br><hr>

<h4>Course List</h4>

<table border="1">
    <tr>
        <th>Course Number</th>
        <th>Course Title</th>
        <th>Instructor</th>
        <th>Department Name</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr>
                    <td>" . $row['course_number'] . "</td>
                    <td>" . $row['course_title'] . "</td>
                    <td>" . $row['instructor_name'] . "</td>
                    <td>" . $row['department_name'] . "</td>
                    <td>
                        <a href='?type=crs&edit=" . $row['course_number'] . "'>Edit</a>
                        <a href='?type=crs&delete=" . $row['course_number'] . "'>Delete</a>
                    </td>
                </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='5'>No courses found</td></tr>";
    }
    ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
