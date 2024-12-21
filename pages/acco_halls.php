<h3>Manage Halls of Residence</h3>
<div class="form-container">
<h4>Hall Form</h4>

<!-- Add Hall Form -->
<form action="" method="post">
    <fieldset>
        <legend>Add Hall</legend>
        <label for="name">Hall Name:</label>
        <input type="text" name="name" placeholder="Enter Hall Name" required>
        <br><br>
        <label for="address">Address:</label>
        <input type="text" name="address" placeholder="Enter Address" required>
        <br><br>
        <label for="phone_no">Telephone:</label>
        <input type="text" name="phone_no" placeholder="Enter Telephone Number" required>
        <br><br>
        <label for="staff_id">Hall Manager:</label>
        <select name="staff_id">
            <option value="">Select Hall Manager</option>
            <?php
            // Fetch hall manager to populate dropdown
                $sql = "SELECT * FROM residence_staff WHERE position = 'Hall Manager'";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['staff_id'] . "'>
                    " . $row['last_name'] . "</option>";
                }
            ?>
        </select>
        <br><br>
        <button type="submit">Add Hall</button>
    </fieldset>  
</form>
            </div>

<?php
// Add Hall Logic
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone_no = $_POST['phone_no'];
        $staff_id = $_POST['staff_id'];

        $sql = "INSERT INTO halls_of_residence (name, address, phone_no,
        staff_id) VALUES ('$name', '$address', '$phone_no', '$staff_id')";
        
        if ($conn->query($sql) === TRUE){
            //echo "Hall added successfully.";
            header("Location: accommodation.php?type=hall");
            //exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

// Fetch Hall Data
    $sql = "SELECT hr.hall_id, hr.name, hr.address, hr.phone_no,
            rs.last_name AS staff_id FROM halls_of_residence hr
            JOIN residence_staff rs ON hr.staff_id = rs.staff_id";
    $result = $conn->query($sql);

// Delete Hall Logic
    if (isset($_GET['delete'])) {
        $hall_id = $_GET['delete'];
        $sql = "DELETE FROM halls_of_residence WHERE hall_id = $hall_id";

        if ($conn->query($sql) === TRUE) {
            header("Location: accommodation.php?type=hall");
            //echo "Hall deleted successfully";
            //exit();
        } else {
            echo "Error deleting record" . $conn->error;
        }
    }    
?>

<br><hr>

<h4>Hall List</h4>

<table border="1">
    <tr>    
        <th>Hall ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Phone Number</th>
        <th>Hall Manager</th>
        <th>Actions</th>
    </tr>

    <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                        <td>" . $row['hall_id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['address'] . "</td>
                        <td>" . $row['phone_no'] . "</td>
                        <td>" . $row['staff_id'] . "</td>
                        <td>
                            <a href='?type=hall&edit=" . $row['hall_id'] . "'>Edit</a>
                            <a href='?type=hall&delete=" . $row['hall_id'] . "'>Delete</a>
                        </td>
                    </tr>
                ";
            }
        } else {
            echo "<tr><td colspan='6'>No halls found</tr>";
        }
    ?>
</table>