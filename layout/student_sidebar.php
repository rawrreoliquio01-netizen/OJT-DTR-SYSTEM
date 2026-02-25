<?php
// student_sidebar.php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
    <h2>OJT Daily Track Record</h2>

    <a href="daily_time_record.php" class="<?= ($currentPage == 'daily_time_record.php') ? 'active' : ''; ?>">
        Daily Time Record
    </a>

    <a href="manage_account.php" class="<?= ($currentPage == 'manage_account.php') ? 'active' : ''; ?>">
        Manage Account
    </a>


</div>