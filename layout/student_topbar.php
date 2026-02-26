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
        <button onclick="openSwitchModal()" class="btn-switch">Switch Account</button>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<!-- SWITCH MODAL -->
<div id="switchAccountModal" class="switch-modal">
    <div class="switch-modal-content">
        <h3>Switch Account</h3>
        <p>Please enter the Student Number:</p>
        <form action="switch_handler.php" method="POST">
            <input type="text" name="new_student_number" required placeholder="Student Number">
            <div class="switch-modal-buttons">
                <button type="submit" class="btn-switch-modal">Switch</button>
                <button type="button" onclick="closeSwitchModal()" class="btn-cancel-modal">Cancel</button>
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

