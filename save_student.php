<?php
include "config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ===== BASIC INFO =====
    $student_number = $_POST['student_number'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $college_department = $_POST['college_department']; // FIXED name
    $program = $_POST['program'];
    $section = $_POST['section'];

    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $contact_number = !empty($_POST['contact_number']) ? $_POST['contact_number'] : null;
    $start_date = $_POST['start_date'];

    // ===== HOURS =====
    $hrs_needed = (int) $_POST['hrs_needed'];
    $remaining_hours = $hrs_needed;

    // ===== COMPANY INFO =====
    $company = $_POST['company'];
    $department_office = $_POST['department_office'];

    // ===== DEFAULT PASSWORD =====
    $defaultPassword = 'ojt2026';
    $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

    // ===== PREPARE QUERY (SECTION ADDED) =====
    $stmt = $conn->prepare("
        INSERT INTO students 
        (student_number, password, first_name, last_name, college_department, program, section, email, contact_number, start_date, hrs_needed, remaining_hours, company, department_office) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // 12 strings + 2 integers = 14 total
    $stmt->bind_param(
        "ssssssssssiiss",
        $student_number,
        $hashedPassword,
        $first_name,
        $last_name,
        $college_department,
        $program,
        $section,
        $email,
        $contact_number,
        $start_date,
        $hrs_needed,
        $remaining_hours,
        $company,
        $department_office
    );

    if ($stmt->execute()) {
        header("Location: view_students.php");
        exit();
    } else {
        echo "Execute Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>