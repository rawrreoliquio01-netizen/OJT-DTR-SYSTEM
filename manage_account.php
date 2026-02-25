<?php
session_start();
include "config/db.php";

$student_number = $_SESSION['student_number'] ?? '';
$student_name   = $_SESSION['student_name'] ?? '';

if (!$student_number) {
    header("Location: student_time.php");
    exit;
}

$pageTitle = "Manage Account";

$message = '';

// Fetch current student info
$stmt = $conn->prepare("SELECT email FROM students WHERE student_number = ?");
$stmt->bind_param("s", $student_number);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email            = $_POST['email'] ?? '';
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!empty($password) && $password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("UPDATE students 
                                    SET email = ?, password = ? 
                                    WHERE student_number = ?");
            $stmt->bind_param("sss", $email, $hashedPassword, $student_number);
        } else {
            // Update email only
            $stmt = $conn->prepare("UPDATE students 
                                    SET email = ? 
                                    WHERE student_number = ?");
            $stmt->bind_param("ss", $email, $student_number);
        }

        if ($stmt->execute()) {
            $message = "Account updated successfully!";
        } else {
            $message = "Error updating account: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $pageTitle; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
    }</style>
</head>
<body>

<div class="layout">

    <?php include "layout/student_sidebar.php"; ?>

    <div class="main-content">

        <?php include "layout/student_topbar.php"; ?>
        <div class="content" style="max-width:600px; margin:30px auto;">

            <div class="prev">
                <h1 style="font-family: 'Nunito', sans-serif;">Manage Account</h1>
            </div>

            <?php if ($message): ?>
                <div class="alert" style="text-align:center; margin-bottom:15px;">
                    <?= htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <label>Student Number</label>
                <input type="text" 
                       value="<?= htmlspecialchars($student_number); ?>" 
                       readonly>

                <label>Name</label>
                <input type="text" 
                       value="<?= htmlspecialchars($student_name); ?>" 
                       readonly>

                <label>Email</label>
                <input type="email" 
                       name="email" 
                       value="<?= htmlspecialchars($student['email'] ?? ''); ?>" 
                       required>

                <div style="margin-top:15px;">
                    <button type="submit">Update Account</button>
                    <a href="student_time_records.php" class="btn-cancel">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
