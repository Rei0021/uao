<?php
include '../includes/db_connect.php';
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        // Fetch user from database
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Optional if roles are added

                header("Location: ../index.php"); // Redirect to homepage
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to the updated CSS -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .error {
            color: red;
        }
        button {
            background-color: #f1485b; /* Primary color */
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: white;
            color: #f1485b;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required> <br> <br>
            <input type="password" name="password" placeholder="Password" required> <br> <br>
            <div>
                <input type="checkbox" name="remember"> Remember Me
            </div>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
