<?php
// Database connection
$host = 'localhost';
$dbname = 'lms project';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if ID is passed
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Fetch the assignment details to get the file name
        $stmt = $pdo->prepare("SELECT * FROM manageassignments WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $assignment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($assignment) {
            // Get the file path and delete the file from the server
            $filePath = 'uploads/assignments/' . $assignment['assignment_file'];
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the file
            }

            // Delete the assignment from the database
            $deleteStmt = $pdo->prepare("DELETE FROM manageassignments WHERE id = :id");
            $deleteStmt->execute(['id' => $id]);

            echo "Assignment deleted successfully.";
        } else {
            echo "Assignment not found.";
        }
    } else {
        echo "No assignment ID provided.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
