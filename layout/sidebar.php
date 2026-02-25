<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
    <h2>OJT Admin</h2>

    <a href="dashboard.php" class="<?= ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
        Dashboard
    </a>

    <a href="add_student.php" class="<?= ($currentPage == 'add_student.php') ? 'active' : ''; ?>">
        Add Student
    </a>

    <a href="view_students.php" class="<?= ($currentPage == 'view_students.php') ? 'active' : ''; ?>">
        View Students
    </a>
</div>
