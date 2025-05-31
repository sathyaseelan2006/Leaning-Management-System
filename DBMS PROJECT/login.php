<?php
session_start();

// Database connection details
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "lms project"; // Ensure this matches your database name

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Retrieve the form data
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Check if all fields are filled
if (!empty($email) && !empty($password) && !empty($role)) {

    // Prepare the SELECT query to get user details
    $query = "SELECT password, role FROM register WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password, $stored_role);
        $stmt->fetch(); // Fetch the result before checking

        // Check if password and role match
        if ($password === $stored_password && $role === $stored_role) {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            // Redirect to appropriate dashboard
            if ($role === "admin") {
                header("Location: dashboard.html");
            } elseif ($role === "student") {
                header("Location: std_dash.html");
            } else {
                echo "Invalid role selection.";
            }
            exit();
        } else {
            echo "Invalid password or role.";
        }
    } else {
        // If email is not found in the database
        echo "User doesn't exist.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "All fields are required.";
}
?>
