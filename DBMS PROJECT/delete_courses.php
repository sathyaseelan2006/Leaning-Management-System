<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the course from the database
    $sql = "DELETE FROM courses WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Course deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
