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
    h2{ 
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
    </style>
    
</body>
</html>

<h2>Course Lists</h2>

<table border="1">
    <tr>
        <th>Course Number</th>
        <th>Course Title</th>
        <th>Instructor</th>
        <th>Department Name</th>
    </tr>

    <?php
        // Fetch Course Data
        $sql = "SELECT c.course_number, c.course_title, i.name AS instructor_id,
                c.department_name
                FROM courses c
                JOIN instructors i ON c.instructor_id = i.instructor_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                        <td>" . $row['course_number'] . "</td>
                        <td>" . $row['course_title'] . "</td>
                        <td>" . $row['instructor_id'] . "</td>
                        <td>" . $row['department_name'] . "</td>
                    </tr>
                ";
            }
        } else {
            echo "<tr><td colspan='5'>No Course found</td></tr>";
        }
    ?>
</table>

<br><hr>

<h2>Instructor Lists</h2>

<table border="1">
    <tr>
        <th>Instructor ID</th>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Instructor's Room</th>
    </tr>

    <?php
        // Fetch Instructor Data
        $sql = "SELECT * FROM instructors";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                        <td>" . $row['instructor_id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['phone_no'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['instructor_room'] . "</td>
                    </tr>
                ";
            }
        } else {
            echo "<tr><td colspan='6'>No Instructor found</td></tr>";
        }
    ?>
</table>

<?php include '../includes/footer.php'; ?>