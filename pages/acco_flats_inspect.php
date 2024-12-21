<?php
include '../includes/db_connect.php';
include '../includes/header.php';
?>

<h2>Manage Inspection</h2>

<h4>Inspection Form</h4>

<!-- Add Inspection Form -->
<form action="" method="post">
    <fieldset>
        <legend>Add Inspection</legend>
        <label for="staff">Staff ID:</label>
        <input type="text" name="staff" placeholder="Enter Staff ID" required>
        <br><br>
        <label for="flat">Flat ID:</label>
        <input type="text" name="flat" placeholder="Enter Flat ID" required>
        <br><br>
        <label for="inspectDate">Inspection Date:</label>
        <input type="date" name="inspectDate" placeholder="Date Inspection" required>
        <br><br>
        <label for="satisfaction">Satisfactory Condition:</label>
        <input type="text" name="satisfaction" placeholder="Yes/No" required>
        <br><br>
        <label for="comments">Additional Comments:</label>
        <input type="text" name="comments" placeholder="Add Comment" required>
        <br><br>
        <button type="submit">Add Inspection</button>
        <br><br>
        <a href="accommodation.php?type=flat">Go Back</a>
    </fieldset>
</form>

<?php
// Add Inspection Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff'];
    $flat_id = $_POST['flat'];
    $date = $_POST['inspectDate'];
    $satisfactor = $_POST['satisfaction'];
    $addComment = $_POST['comments'];

    $sql = "INSERT INTO inspections (staff_id, flat_id, inspection_date,
            satisfactory_condition, comments) VALUES ('$staff_id', '$flat_id', '$date',
            '$satisfactor', '$addComment')";

    if ($conn->query($sql) === TRUE) {
        header("Location: accommodation.php?type=flat");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<?php include '../includes/footer.php'; ?>
