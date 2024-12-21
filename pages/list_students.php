<?php
    include '../includes/db_connect.php';
    include '../includes/header.php';
?>

<h2>Student Lists</h2>

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
        // Fetch Student Data
        $sql = "SELECT s.banner_number, s.first_name, s.last_name, s.category,
                s.special_needs, s.additional_comments, s.current_status, s.major, s.minor,
                a.full_name AS adviser_id, c.department_name AS course_number
                FROM ((students s
                JOIN advisers a ON s.adviser_id = a.adviser_id)
                JOIN courses c ON s.course_number = c.course_number)";
        $result = $conn->query($sql);

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
                            <a href='student_details.php?banner_num=" . $row['banner_number'] . "'>View Details</a>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='18'>No Student found</td></tr>";
        }
    ?>
</table>

<?php include '../includes/footer.php'; ?>