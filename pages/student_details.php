<?php
    include '../includes/db_connect.php';
    include '../includes/header.php';
?>

<?php
    $bannerNum = $_GET['banner_num'] ?? NULL;

    if (!$bannerNum) {
        die("Banner Number is missing.");
    }

// Fetch student details
    $fetchStudent = "SELECT s.banner_number, s.first_name, s.last_name, si.gender AS sex, si.date_of_birth
                    AS dob, si.nationality AS ntly, si.home_address AS homeAdd, si.email AS emailAdd,
                    si.mobile_phone AS contactNum, s.category, s.special_needs, s.additional_comments,
                    s.current_status, s.major, s.minor FROM students s JOIN student_info si
                    ON s.banner_number = si.banner_number WHERE s.banner_number = $bannerNum";
    $student_result = $conn->query($fetchStudent);
    if (!$student_result || $student_result->num_rows === 0) {
        die("Student information not found.");
    }

    $student = $student_result->fetch_assoc();

// Fetch next-of-kin details
    $kin_result = $conn->query("SELECT * FROM next_of_kin WHERE banner_number = $bannerNum");
?>

<h2>Student Details</h2>

<div class="details-container">
    <?php
        echo "<p><strong>Banner Number: </strong>" . $student['banner_number'] . "</p>";
        echo "<p><strong>Name: </strong>" . $student['first_name'] . " " . $student['last_name'] . "</p>";
        echo "<p><strong>Gender: </strong>" . $student['sex'] . "</p>";
        echo "<p><strong>Date of Birth: </strong>" . $student['dob'] . "</p>";
        echo "<p><strong>Nationality: </strong>" . $student['ntly'] . "</p>";
        echo "<p><strong>Address: </strong>" . $student['homeAdd'] . "</p>";
        echo "<p><strong>Email: </strong>" . $student['emailAdd'] . "</p>";
        echo "<p><strong>Phone: </strong>" . $student['contactNum'] . "</p>";
        echo "<p><strong>Category: </strong>" . $student['category'] . "</p>";
        echo "<p><strong>Special Needs: </strong>" . $student['special_needs'] . "</p>";
        echo "<p><strong>Additional Comments: </strong>" . $student['additional_comments'] . "</p>";
        echo "<p><strong>Status: </strong>" . $student['current_status'] . "</p>";
        echo "<p><strong>Major: </strong>" . $student['major'] . "</p>";
        echo "<p><strong>Minor: </strong>" . $student['minor'] . "</p>";
    ?>
</div>

<h3>Next-of-Kin Information</h3>

<div class="kin-container">
    <?php
        if ($kin_result->num_rows > 0) {
            while ($kin = $kin_result->fetch_assoc()) {
                echo "<p><strong>Name: </strong>" . $kin['name'] . "</p>";
                echo "<p><strong>Relationship: </strong>" . $kin['relationship'] . "</p>";
                echo "<p><strong>Phone: </strong>" . $kin['contact_phone'] . "</p>";
                echo "<p><strong>Address: </strong>" . $kin['address'] . "</p>";
            }
        } else {
            echo "<p>No next-of-kin information found.</p>";
        }
    ?>
</div>

<a href="list_students.php">Back to Student Lists</a>

<?php include '../includes/footer.php'; ?>