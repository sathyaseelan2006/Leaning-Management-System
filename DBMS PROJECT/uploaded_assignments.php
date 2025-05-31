<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "lms project";
$conn = new mysqli($host, $user, $pass, $db);

// Create 'assignments' folder if not exists
$uploadDir = "uploads/assignments/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['assignmentTitle']);
    $fileName = basename($_FILES["assignmentFile"]["name"]);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $allowed = ['pdf', 'docx', 'txt'];

    if (in_array($fileType, $allowed)) {
        if (move_uploaded_file($_FILES["assignmentFile"]["tmp_name"], $targetFilePath)) {
            $stmt = $conn->prepare("INSERT INTO assignments (title, file_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $title, $targetFilePath);
            $stmt->execute();
            $stmt->close();
        }
    }
}
header("Location: manage_assignment.html"); // Redirect back
exit();
?>
