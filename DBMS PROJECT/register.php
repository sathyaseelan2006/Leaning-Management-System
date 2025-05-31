<?php
// Retrieve the form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];  // Retrieve the role from the form
$course = $_POST['course'];  // Retrieve the selected course

// Check if all fields are filled
if (!empty($name) && !empty($email) && !empty($password) && !empty($role) && !empty($course)) {
    
    // Email validation (basic format check)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        die();
    }

    // Database connection details
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "lms project";  // Ensure this matches your actual database name

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        // Prepare the SELECT query to check if the email already exists
        $SELECT = "SELECT email FROM register WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO register (name, email, password, role, course) VALUES (?, ?, ?, ?, ?)";

        // Prepare statement for email checking
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        // Check if the email already exists
        if ($rnum == 0) {
            // Close the previous statement and prepare the insert query
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssss", $name, $email, $password, $role, $course);  // Store plain-text password and course
            $stmt->execute();
            
            // Redirect to login page after successful registration
            header("Location: login.html");
            exit();
        } else {
            // Email already exists
            echo "Someone has already registered using this email.";
        }
        
        // Close the prepared statement and the connection
        $stmt->close();
        $conn->close();
    }
} else {
    // Handle empty fields
    echo "All fields are required.";
    die();
}
?>
