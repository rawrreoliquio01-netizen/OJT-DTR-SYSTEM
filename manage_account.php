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
    <link rel="stylesheet" href="css/student_topbar.css">
    <link rel="stylesheet" href="css/manage_account.css">
</head>
<body>

<div class="layout">

    <?php include "layout/student_sidebar.php"; ?>

    <div class="main-content">

        <?php include "layout/student_topbar.php"; ?>
        
        <div class="account-container">

            <?php if ($message): ?>
                <div class="alert-container">
                    <div class="alert">
                        <?= htmlspecialchars($message); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-wrapper">
                <div class="form-container">
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
                    <div class="button-group">
                        <button type="submit" class="btn-update">
                            Update Account
                        </button>
                        <a href="daily_time_record.php" class="btn-cancel">Cancel</a>
                    </div>

                </form>
            </div>

        </div>
    </div>

</div>

</body>
</html>