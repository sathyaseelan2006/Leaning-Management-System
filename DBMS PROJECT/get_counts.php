<?php
include 'db.php';

$response = [
    "students" => 0,
    "courses" => 0,
    "assignments" => 0,
    "attendance" => 0
];

// Count students
$result = $conn->query("SELECT COUNT(*) as count FROM students");
$row = $result->fetch_assoc();
$response['students'] = $row['count'];

// Count unique courses
$result = $conn->query("SELECT COUNT(DISTINCT course_name) as count FROM courses");
$row = $result->fetch_assoc();
$response['courses'] = $row['count'];

// Count assignments
$result = $conn->query("SELECT COUNT(*) as count FROM assignments");
$row = $result->fetch_assoc();
$response['assignments'] = $row['count'];

// Count today’s attendance
$today = date("Y-m-d");
$result = $conn->query("SELECT COUNT(*) as count FROM attendance WHERE date='$today'");
$row = $result->fetch_assoc();
$response['attendance'] = $row['count'];

echo json_encode($response);
?>
