<?php
$pageTitle = "Dashboard";
include "config/db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="wrapper">

    <?php include "layout/sidebar.php"; ?>

    <div class="main">

        <?php include "layout/topbar.php"; ?>

        <div class="content">
            <h2>Welcome to OJT Management System</h2>
            <p>Use the sidebar to manage students.</p>
        </div>

    </div>
</div>

</body>
</html>
