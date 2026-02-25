<?php

include "config/db.php";
date_default_timezone_set('Asia/Manila');

$student_number = $_SESSION['student_number'] ?? '';
$student_name   = $_SESSION['student_name'] ?? '';

if (!$student_number) {
    header("Location: index.php");
    exit;
}
?>

<div class="topbar">
   <h2>Welcome, <?= htmlspecialchars($student_name); ?>!</h2>

    <div class="topbar-actions">
        <button onclick="openSwitchModal()" class="btn-switch">
                Switch Account
        </button>
        <a href="logout.php" style="background-color: #dc3545;
    color: white;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    transition: 0.3s;">
            Logout
        </a>
    </div>
</div>

<!-- SWITCH MODAL -->
<div id="switchAccountModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7);">
    <div style="background: white; margin: 12% auto; padding: 30px; width: 350px; border-radius: 15px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
        <h3 style="margin-top: 0; color: #2c3e50;">Switch Account</h3>
        <p style="color: #7f8c8d; font-size: 14px;">Please enter the Student Number:</p>
        <form action="switch_handler.php" method="POST">
            <input type="text" name="new_student_number" required placeholder="Student Number" style="width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="flex:1; background:#5d7c6d; color:white; border:none; padding:12px; border-radius:8px; cursor:pointer; font-weight:bold;">Switch</button>
                <button type="button" onclick="closeSwitchModal()" style="flex:1; background:#e74c3c; color:white; border:none; padding:12px; border-radius:8px; cursor:pointer;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openSwitchModal() {
    document.getElementById('switchAccountModal').style.display = 'block';
}
function closeSwitchModal() {
    document.getElementById('switchAccountModal').style.display = 'none';
}

function openTimeoutModal(sessionId, recordId, accomplishment) {
    document.getElementById('modal_session_id').value = sessionId;
    document.getElementById('modal_record_id').value = recordId;
    document.getElementById('modal_accomplishment').value = accomplishment;
    document.getElementById('timeoutModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('timeoutModal').style.display = 'none';
}

window.onclick = function(event) {
    let switchModal = document.getElementById('switchAccountModal');
    let timeoutModal = document.getElementById('timeoutModal');

    if (event.target === switchModal) switchModal.style.display = "none";
    if (event.target === timeoutModal) timeoutModal.style.display = "none";
}
</script>


