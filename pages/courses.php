

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
    <h3>Manage Course</h3>
<div class="form-container">
<h4>Course Form</h4>

<form action="" method="post">
    <fieldset>
        <legend>Add Course</legend>
        <label for="course_number">Course ID:</label>
        <input type="text" name="course_number" placeholder="Enter Course Number" required>
        <br><br>
        <label for="course_title">Course Title:</label>
        <input type="text" name="course_title" placeholder="Course Title" required>
        <br><br>
        <label for="instructor_id">Instructor:</label>
        <select name="instructor_id">
            <option value="">Select Instructor</option>
            <?php
            // Fetch instructor to populate dropdown
                $sql = "SELECT * FROM instructors";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['instructor_id'] . "'>
                    " . $row['name'] . "</option>";
                }
            ?>
        </select>
        <br><br>
        <label for="dept_name">Department Name:</label>
        <input type="text" name="dept_name" placeholder="Department Name" required>
        <br><br>
        <button type="submit">Add Course</button>
    </fieldset>
</form>
            </div>

<?php
// Add Course Logic
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $courseNum = $_POST['course_number'];
        $courseTitle = $_POST['course_title'];
        $instructor_id = $_POST['instructor_id'];
        $dept_name = $_POST['dept_name'];

        $sql = "INSERT INTO courses (course_number, course_title,
                instructor_id, department_name) VALUES ('$courseNum',
                '$courseTitle', '$instructor_id', '$dept_name')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Course added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

// Fetch Course Data
    $sql = "SELECT c.course_number, c.course_title, i.name AS instructor_id,
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

<h4>List</h4>

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
                        <td>" . $row['instructor_id'] . "</td>
                        <td>" . $row['department_name'] . "</td>
                        <td>
                            <a href='?type=crs&edit=" . $row['course_number'] . "'>Edit</a>
                            <a href='?type=crs&delete=" . $row['course_number'] . "'>Delete</a>
                        </td>
                    </tr>
                ";
            }
        } else {
            echo "<tr><td colspan='5'>No Course found</td></tr>";
        }
    ?>
</table>