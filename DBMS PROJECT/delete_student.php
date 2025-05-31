<?php
// Database connection
$host = "localhost";
$username = "root"; // Replace if needed
$password = "";     // Replace if needed
$database = "lms project"; // Replace with your actual DB name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed");
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
} else {
    echo "no_email";
}

$conn->close();
?>
