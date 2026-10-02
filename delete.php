<?php
require_once 'db.php';

$student_id = $_GET['id'] ?? null;

if ($student_id && is_numeric($student_id)) {
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: students.php?msg=deleted");
exit();
?>
