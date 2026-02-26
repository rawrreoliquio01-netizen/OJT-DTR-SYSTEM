<?php
$pageTitle = "OJT Students";
include "config/db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/topbar.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/tables.css">
    <link rel="stylesheet" href="css/buttons.css">
</head>
<body>

<div class="wrapper">

    <?php include "layout/sidebar.php"; ?>

    <div class="main">

        <?php include "layout/topbar.php"; ?>

        <div class="content">

            <table>
                <tr>
                    <th>ID</th>
                    <th>Student No</th>
                    <th>Name</th>
                    <th>Program</th>
                    <th>College / Department</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Start</th>
                    <th>End</th>
                </tr>

                <?php
                $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
                while($row = $result->fetch_assoc()):
                ?>

                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['student_number']; ?></td>
                    <td><?= $row['first_name'] . " " . $row['last_name']; ?></td>
                    <td><?= $row['program']; ?></td>
                    <td><?= $row['college_department']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['contact_number']; ?></td>
                    <td><?= $row['start_date']; ?></td>
                    <td><?= $row['end_date']; ?></td>
                </tr>

                <?php endwhile; ?>

            </table>

        </div>

    </div>
</div>

</body>
</html>
