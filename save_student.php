<?php
include "config/db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $student_number = $_POST['student_number'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $college_select = $_POST['college_select'];
    $program = $_POST['program'];
    $college_department = $college_select . ' - ' . $program;
    $email = $_POST['email'] ?? null;
    $contact_number = $_POST['contact_number'] ?? null;
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;

    // Default password
    $defaultPassword = 'ojt2026';
    $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO students (student_number, first_name, last_name, program, college_department, email, contact_number, start_date, end_date, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $student_number, $first_name, $last_name, $program, $college_department, $email, $contact_number, $start_date, $end_date, $hashedPassword);

    if($stmt->execute()){
        header("Location: view_students.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>