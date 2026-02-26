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
    <style>
        .container { 
            padding: 20px; 
        }

        /* Title stays on the left */
        .prev {
            text-align: left;
            margin-bottom: 20px;
        }

        /* Centering the form block on the page */
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 40px 0;
            width: 100%;
        }

        .form-container {
            width: 700px;
            max-width: 90%;
            background: #fff;
            padding: 50px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-family: 'Nunito', sans-serif;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            font-family: 'Nunito', sans-serif;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 0;
            box-sizing: border-box;
        }

        .btn-group {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        .btn-update {
            background: #004d26;
            color: #f7f6f6;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-update:hover {
            background: #218838;
            color: #f7f6f6;
        }

        .btn-cancel {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            background: #cc0000;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn-cancel:hover {
            background: #ff0000;
            color: white;
        }
    </style>
</head>
<body>

<div class="layout">

    <?php include "layout/student_sidebar.php"; ?>

    <div class="main-content">

        <?php include "layout/student_topbar.php"; ?>
        
        <div class="container">

            <?php if ($message): ?>
                <div style="display: flex; justify-content: center;">
                    <div class="alert" style="width: 100%; max-width: 600px; text-align: center; margin-bottom: 15px; background: #e7f3fe; color: #0c5460; padding: 10px; border-radius: 5px;">
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
                           readonly style="background-color: #eee;">

                    <label>Name</label>
                    <input type="text" 
                           value="<?= htmlspecialchars($student_name); ?>" 
                           readonly style="background-color: #eee;">

                    <label>Email</label>
                    <input type="email" 
                           name="email" 
                           value="<?= htmlspecialchars($student['email'] ?? ''); ?>" 
                           required>
                    <div style="margin-top:20px;">
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