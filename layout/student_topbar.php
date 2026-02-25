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
        <button onclick="openSwitchModal()" class="btn-switch" style="font-family: 'Nunito', sans-serif; background:#004d26; color:#f7f6f6; padding: 8px 16px; border: none; border-radius: 6px; font-size: 14px; cursor: pointer; transition: 0.3s; font-weight: 600;"
                onmouseover="this.style.background='#003d1e'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 77, 38, 0.3)';"
                onmouseout="this.style.background='#004d26'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                Switch Account
        </button>
        <a href="logout.php" style="font-family: 'Nunito', sans-serif; background-color: #da0e0eff;
    color: white;
    padding: 8px 12px;
    text-decoration: none;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.3s; display: inline-block; cursor: pointer;"
            onmouseover="this.style.backgroundColor='#ff0000ff'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 77, 38, 0.3)';"
            onmouseout="this.style.backgroundColor='#da0e0eff'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            Logout
        </a>
    </div>
</div>

<!-- SWITCH MODAL -->
<div id="switchAccountModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7);">
    <div style="background: white; margin: 12% auto; padding: 30px; width: 350px; border-radius: 15px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
        <h3 style="font-family: 'Nunito', sans-serif; margin-top: 0; color: #2c3e50;">Switch Account</h3>
        <p style="font-family: 'Nunito', sans-serif; color: #7f8c8d; font-size: 14px;">Please enter the Student Number:</p>
        <form action="switch_handler.php" method="POST">
            <input type="text" name="new_student_number" required placeholder="Student Number" style="font-family: 'Nunito', sans-serif; width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="font-family: 'Nunito', sans-serif; flex:1; background:#004d26; color:white; border:none; padding:12px; border-radius:8px; cursor:pointer; font-weight:bold; transition:all 0.3s;" 
                        onmouseover="this.style.background='#003d1e'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 77, 38, 0.3)';" 
                        onmouseout="this.style.background='#004d26'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">Switch</button>
                <button type="button" onclick="closeSwitchModal()" style="font-family: 'Nunito', sans-serif; flex:1; background:#ff0000; color:white; border:none; padding:12px; border-radius:8px; cursor:pointer; transition:all 0.3s;" 
                        onmouseover="this.style.background='#cc0000'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(255, 0, 0, 0.3)';" 
                        onmouseout="this.style.background='#ff0000'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">Cancel</button>
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

