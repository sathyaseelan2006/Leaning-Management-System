<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['studentName'];
    $email = $_POST['studentEmail'];
    $course = $_POST['enrolledCourses'];
    $photoPath = "";

    // Upload photo if selected
    if (!empty($_FILES['studentPhoto']['name'])) {
        $targetDir = "uploads/students/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $photoPath = $targetDir . basename($_FILES["studentPhoto"]["name"]);
        move_uploaded_file($_FILES["studentPhoto"]["tmp_name"], $photoPath);
    }

    // Check if student already exists
    $check = $conn->prepare("SELECT id FROM students WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Update existing student
        if ($photoPath) {
            $stmt = $conn->prepare("UPDATE students SET name=?, course=?, photo=? WHERE email=?");
            $stmt->bind_param("ssss", $name, $course, $photoPath, $email);
        } else {
            $stmt = $conn->prepare("UPDATE students SET name=?, course=? WHERE email=?");
            $stmt->bind_param("sss", $name, $course, $email);
        }
    } else {
        // Insert new student
        $stmt = $conn->prepare("INSERT INTO students (name, email, course, photo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $course, $photoPath);
    }

    if ($stmt->execute()) {
        echo "Student profile updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
