<?php
session_start();
date_default_timezone_set('Asia/Manila');
include "config/db.php";

$currentPeriod = (date('H') < 12) ? 'AM' : 'PM';
$today = date('Y-m-d');

function redirectWithMessage($msg){
    $_SESSION['flash_message'] = $msg;
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {

    $student_number = $_POST['student_number'];
    $current_time = date('H:i:s');
    $current_hour = date('H');
    $period = ($current_hour < 12) ? 'AM' : 'PM';

    // Check student
    $stmt = $conn->prepare("SELECT first_name,last_name FROM students WHERE student_number=?");
    $stmt->bind_param("s", $student_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$student = $result->fetch_assoc()) {
        redirectWithMessage("Student not found.");
    }

    $_SESSION['student_number'] = $student_number;
    $_SESSION['student_name'] = $student['first_name']." ".$student['last_name'];

    // Ensure daily record exists
    $check = $conn->prepare("SELECT * FROM time_records WHERE student_number=? AND record_date=?");
    $check->bind_param("ss", $student_number, $today);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO time_records (student_number,student_name,record_date) VALUES (?,?,?)");
        $insert->bind_param("sss", $student_number, $_SESSION['student_name'], $today);
        $insert->execute();
        $record_id = $insert->insert_id;
    } else {
        $record = $res->fetch_assoc();
        $record_id = $record['id'];
    }

    // Check last session in this period
    $sessionCheck = $conn->prepare("SELECT * FROM time_sessions 
                                    WHERE record_id=? AND period=? 
                                    ORDER BY id DESC LIMIT 1");
    $sessionCheck->bind_param("is", $record_id, $period);
    $sessionCheck->execute();
    $sessionRes = $sessionCheck->get_result();

    if ($sessionRes->num_rows > 0) {
        $lastSession = $sessionRes->fetch_assoc();

        if (empty($lastSession['time_out'])) {
            // ACTIVE → Save TIME OUT
            $update = $conn->prepare("UPDATE time_sessions SET time_out=? WHERE id=?");
            $update->bind_param("si", $current_time, $lastSession['id']);
            $update->execute();
            redirectWithMessage("$period Time Out recorded.");
        }
    }

    // Otherwise → Save TIME IN
    $insertSession = $conn->prepare("INSERT INTO time_sessions (record_id,period,time_in) VALUES (?,?,?)");
    $insertSession->bind_param("iss", $record_id, $period, $current_time);
    $insertSession->execute();

    redirectWithMessage("$period Time In recorded.");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>PSAU OJT DTR</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/index.css">
</head>
<body>

<div class="header"><h2>PSAU OJT DTR</h2><button onclick="openLoginModal()" class="btn-switch">Login</button></div>

<div class="container">
    <div class="clock-widget">
        <iframe src="https://free.timeanddate.com/clock/iaagilca/n3357/szw300/szh300/cf100/hnce1ead6" frameborder="0" width="300" height="300"></iframe>
        <div class="date-container">
            <iframe src="https://free.timeanddate.com/clock/iaagj3fz/n3357/fs26" frameborder="0" width="209" height="33"></iframe>
        </div>
    </div>

    <div class="main-content">
        <h2>Welcome to I-Café!</h2>
        <form method="POST">
            <label>Student Number</label>
            <input type="text" name="student_number" required>
            <button type="submit" name="save" class="btn-switch">Save</button>
        </form>

        <p class="info-text">Current Period: <b><?= $currentPeriod ?></b></p>

        <?php if(isset($_SESSION['flash_message'])): ?>
        <p class="success-message">
            <?= htmlspecialchars($_SESSION['flash_message']) ?>
        </p>
        <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
    </div>
</div>

<div id="switchAccountModal" class="modal">
    <div class="modal-content">
        <h3>Log to your Account</h3>
        <p>Please enter your Student Number:</p>
        
        <form action="switch_handler.php" method="POST">
            <input type="text" name="new_student_number" required placeholder="Student Number (e.g. 202100919)">
            
            <div class="modal-buttons">
                <button class="btn-login btn-switch" type="submit">Login</button>
                <button class="btn-cancel" type="button" onclick="closeLoginModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openLoginModal() {
    document.getElementById('switchAccountModal').style.display = 'block';
}
function closeLoginModal() {
    document.getElementById('switchAccountModal').style.display = 'none';
}
// Close if clicking background
window.onclick = function(event) {
    let modal = document.getElementById('switchAccountModal');
    if (event.target == modal) { modal.style.display = "none"; }
}
</script>

<script>
function openTimeoutModal(sessionId, recordId) {
    document.getElementById('modal_session_id').value = sessionId;
    document.getElementById('modal_record_id').value = recordId;
    document.getElementById('timeoutModal').style.display = 'block';
}
function closeModal() {
    document.getElementById('timeoutModal').style.display = 'none';
}
</script>

</body>
</html>