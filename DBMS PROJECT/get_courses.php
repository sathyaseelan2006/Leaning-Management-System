<?php
include('db.php');

// Fetch all courses from the database
$sql = "SELECT id, course_code, course_name, instructor, description FROM courses";
$result = $conn->query($sql);

$courses = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
    echo json_encode($courses);
} else {
    echo json_encode(array());
}

$conn->close();
?>
    