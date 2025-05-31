<?php
// Include your database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the form fields are set
    if (isset($_POST['courseName']) && isset($_POST['courseCode']) && isset($_POST['instructor']) && isset($_POST['description'])) {
        $courseName = $_POST['courseName']; // Added course name
        $courseCode = $_POST['courseCode'];
        $instructor = $_POST['instructor'];
        $description = $_POST['description'];

        // Prepare and execute SQL statement
        $sql = "INSERT INTO courses (course_name, course_code, instructor, description) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $courseName, $courseCode, $instructor, $description); // Added course name binding

            if ($stmt->execute()) {
                echo "Course added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>
