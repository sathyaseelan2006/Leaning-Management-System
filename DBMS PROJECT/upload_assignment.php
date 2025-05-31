<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['assignmentTitle'];
    $filePath = "";

    if (!empty($_FILES['assignmentFile']['name'])) {
        $targetDir = "uploads/assignments/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $filePath = $targetDir . basename($_FILES["assignmentFile"]["name"]);
        move_uploaded_file($_FILES["assignmentFile"]["tmp_name"], $filePath);

        $stmt = $conn->prepare("INSERT INTO assignments (title, file_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $filePath);

        if ($stmt->execute()) {
            echo "Assignment uploaded successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "No file selected.";
    }
}
?>
