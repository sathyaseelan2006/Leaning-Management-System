<?php
// Database connection
$host = 'localhost'; // Change this to your database host
$dbname = 'lms project'; // Change this to your database name
$username = 'root'; // Change this to your database username
$password = ''; // Change this to your database password

try {
    // Establishing the connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Fetch the assignment title and file data
        $assignmentTitle = htmlspecialchars($_POST['assignmentTitle']); // Sanitize input
        $assignmentFile = $_FILES['assignmentFile']['name'];
        $targetDir = "uploads/assignments/";
        $targetFile = $targetDir . basename($assignmentFile);
        $fileSize = $_FILES['assignmentFile']['size'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB

        // Check if the file size is within the limit
        if ($fileSize > $maxFileSize) {
            echo "File is too large. Maximum size is 5MB.";
            exit();
        }

        // Check if the file is a valid format (PDF, Word, etc.)
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (!in_array($fileType, ['pdf', 'docx', 'txt'])) {
            echo "Only PDF, DOCX, and TXT files are allowed.";
            exit();
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['assignmentFile']['tmp_name'], $targetFile)) {
            // Insert assignment details into the database
            $sql = "INSERT INTO manageassignments (assignment_title, assignment_file) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$assignmentTitle, $assignmentFile]);

            echo "Assignment uploaded successfully.";
        } else {
            echo "There was an error uploading the assignment file.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
