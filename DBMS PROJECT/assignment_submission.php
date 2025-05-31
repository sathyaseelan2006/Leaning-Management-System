<?php
// Define the directory to save the uploaded files
$uploadDirectory = 'uploads/';

// Check if the upload directory exists, if not create it
if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}

// Check if a file was uploaded for each assignment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assignmentName = ''; // Variable to hold the assignment name

    // Check if the 'assignment1', 'assignment2', or 'assignment3' field exists and process accordingly
    if (isset($_FILES['assignment1'])) {
        $assignmentName = 'assignment1';
    } elseif (isset($_FILES['assignment2'])) {
        $assignmentName = 'assignment2';
    } elseif (isset($_FILES['assignment3'])) {
        $assignmentName = 'assignment3';
    }

    if ($assignmentName) {
        // Get the uploaded file
        $file = $_FILES[$assignmentName];

        // Check if there were any errors during file upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die("File upload failed with error code: " . $file['error']);
        }

        // Generate a unique filename to avoid overwriting existing files
        $targetFile = $uploadDirectory . basename($file['name']);
        $targetFile = $uploadDirectory . uniqid() . '-' . basename($file['name']);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // File successfully uploaded
            echo "The file " . htmlspecialchars($file['name']) . " has been uploaded successfully.<br>";
        } else {
            // Error moving the file
            echo "Sorry, there was an error uploading your file.<br>";
        }
    } else {
        echo "No file was uploaded for the assignment.<br>";
    }
} else {
    echo "Invalid request method.";
}
?>
