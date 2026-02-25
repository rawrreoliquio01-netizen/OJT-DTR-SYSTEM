<?php
// switch_handler.php
session_start();
// Based on your folder structure, config is in a subfolder
include "config/db.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_student_number'])) {
    $new_id = mysqli_real_escape_string($conn, $_POST['new_student_number']);

    // Check if the student exists in the 'students' table
    $query = "SELECT student_number, first_name, last_name FROM students WHERE student_number = '$new_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
        
        // Update Session with the new student info
        // We use 'student_number' as the identifier as seen in your table
        $_SESSION['student_number'] = $student['student_number'];
        $_SESSION['student_name'] = $student['first_name'] . ' ' . $student['last_name'];

        // Redirect back to the daily time record page
        header("Location: daily_time_record.php");
        exit;
    } else {
        // If student number doesn't exist in database
        echo "<script>
                alert('Error: Student Number " . htmlspecialchars($new_id) . " not found.');
                window.location.href = 'daily_time_record.php';
              </script>";
        exit;
    }
} else {
    header("Location: daily_time_record.php");
    exit;
}
?>