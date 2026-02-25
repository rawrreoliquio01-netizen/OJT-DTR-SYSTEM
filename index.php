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
<style>
/* Your previous styles unchanged */
body{font-family: 'Nunito', sans-serif;background:#F5F1E8;margin:0;padding:0;}
.header{display:flex;justify-content:space-between;align-items:center;padding:15px 30px;background:#E8E1D5;box-shadow:0 2px 5px rgba(0,0,0,0.1);border-bottom:3px solid transparent;background-image:linear-gradient(#E8E1D5, #E8E1D5), linear-gradient(90deg, #FFD700, #FFEB3B, #FFD700);background-origin:border-box;background-clip:padding-box, border-box;background-repeat:no-repeat;background-position:0 0, 0 100%;background-size:100% 100%, 100% 3px;}
.header a{font-family: 'Nunito', sans-serif;text-decoration:none;padding:10px 20px;background:#004d26;color:#fff;border-radius:5px;font-weight:bold;}
.header a:hover{background:#0056b3;}
.container{max-width:1200px;margin:60px auto;background:#fff;padding:50px;border-radius:15px;box-shadow:0 8px 32px rgba(0,0,0,0.1);position:relative;min-height:500px;}
.clock-widget{position:absolute;top:80px;left:140px;z-index:10;}
.main-content{margin-left:480px;max-width:520px;padding:50px;background:#f9f9f9;border-radius:10px;}
.container h2{font-family: 'Nunito', sans-serif;text-align:center;margin-bottom:20px;}
.container form label{font-family: 'Nunito', sans-serif;display:block;margin-top:10px;margin-bottom:5px;}
.container form input, .container form select, .container form textarea{font-family: 'Nunito', sans-serif;width:100%;padding:12px;border-radius:8px;border:1px solid #ddd;box-sizing:border-box;font-size:16px;transition:border-color 0.3s;}
.container form input:focus, .container form select:focus, .container form textarea:focus{border-color:#007bff;outline:none;}
.container form button{font-family: 'Nunito', sans-serif;width:100%;margin-top:20px;padding:15px;background:#004d26;color:#fff;border:none;border-radius:8px;font-weight:bold;cursor:pointer;font-size:16px;transition:background 0.3s;}
.container form button:hover{background:#218838;}
.modal{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);display:flex;align-items:center;justify-content:center;z-index:9999;}
.modal-content{background:#fff;padding:30px;border-radius:15px;width:450px;box-shadow:0 12px 48px rgba(0,0,0,0.3);animation:slideIn 0.3s ease-out;position:relative;z-index:10000;}
.modal-content button{font-family: 'Nunito', sans-serif;padding:10px 20px;margin-right:10px;border:none;border-radius:8px;cursor:pointer;font-weight:bold;transition:all 0.3s;}
.modal-content button:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,0.15);}
@keyframes slideIn{from{opacity:0;transform:translateY(-20px);}to{opacity:1;transform:translateY(0);}}
</style>
</head>
<body>

<div class="header"><h2 style="font-family: 'Nunito', sans-serif;">PSAU OJT DTR</h2><button onclick="openLoginModal()" style="font-family: 'Nunito', sans-serif; background:#004d26;color:#fff;padding:10px 20px;border:none;border-radius:5px;font-weight:bold;cursor:pointer;transition:all 0.3s;"
            onmouseover="this.style.background='#003d1e'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 77, 38, 0.3)';"
            onmouseout="this.style.background='#004d26'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">Login</button></div>



<div class="container">
    <div class="clock-widget">
        <iframe src="https://free.timeanddate.com/clock/iaagilca/n3357/szw300/szh300/cf100/hnce1ead6" frameborder="0" width="300" height="300"></iframe>
        <div style="margin-top: 35px; text-align: center;">
            <iframe src="https://free.timeanddate.com/clock/iaagj3fz/n3357/fs26" frameborder="0" width="209" height="33"></iframe>
        </div>
    </div>

    <div class="main-content">
        <h2 style="font-family: 'Nunito', sans-serif;">Welcome to I-Café!</h2>
        <form method="POST">
            <label>Student Number</label>
            <input type="text" name="student_number" required>
            <button type="submit" name="save" style="width:100%;margin-top:20px;padding:15px;background:#004d26;color:#fff;border:none;border-radius:8px;font-weight:bold;cursor:pointer;font-size:16px;transition:all 0.3s;"
                    onmouseover="this.style.background='#003d1e'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 77, 38, 0.3)';"
                    onmouseout="this.style.background='#004d26'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">Save</button>
        </form>

        <p style="font-family: 'Nunito', sans-serif; text-align:center;margin-top:30px;">Current Period: <b><?= $currentPeriod ?></b></p>

        <?php if(isset($_SESSION['flash_message'])): ?>
        <p style="font-family: 'Nunito', sans-serif; text-align:center;color:green;font-weight:bold;">
            <?= htmlspecialchars($_SESSION['flash_message']) ?>
        </p>
        <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
    </div>
</div>

<div id="switchAccountModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7);">
    <div style="background: white; margin: 12% auto; padding: 30px; width: 350px; border-radius: 15px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
        <h3 style="font-family: 'Nunito', sans-serif; margin-top: 0; color: #2c3e50;">Log to your Account</h3>
        <p style="font-family: 'Nunito', sans-serif; color: #7f8c8d; font-size: 14px;">Please enter your Student Number:</p>
        
        <form action="switch_handler.php" method="POST">
            <input type="text" name="new_student_number" required placeholder="Student Number (e.g. 202100919)" 
                   style="font-family: 'Nunito', sans-serif; width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            
            <div style="display: flex; gap: 10px;">
                <button class="btn-login" type="submit" style="font-family: 'Nunito', sans-serif; flex: 1; background: #004d26; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold; transition: all 0.3s;" 
                        onmouseover="this.style.background='#003d1e'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 77, 38, 0.3)';" 
                        onmouseout="this.style.background='#004d26'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">Login</button>
                <button class="btn-cancel" type="button" onclick="closeLoginModal()" style="font-family: 'Nunito', sans-serif; flex: 1; background: #ff0000; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; transition: all 0.3s;" 
                        onmouseover="this.style.background='#cc0000'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(255, 0, 0, 0.3)';" 
                        onmouseout="this.style.background='#ff0000'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">Cancel</button>
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