<?php
// Database connection
$host = "localhost";
$username = "root"; // Replace if needed
$password = "";     // Replace if needed
$database = "lms project"; // Replace with your actual DB name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed', 'message' => $conn->connect_error]));
}

// Fetch name, email, course, and role from register table
$sql = "SELECT name, email, course, role FROM register";  // Assuming 'role' column exists in the register table
$result = $conn->query($sql);

$students = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Only add the name if the role is not "admin"
        if ($row['role'] !== 'admin') {
            $students[] = $row;
        }
    }
} else {
    $students = ['message' => 'No students found'];
}

// Output JSON
header('Content-Type: application/json');
echo json_encode($students);

// Close connection
$conn->close();
?>
