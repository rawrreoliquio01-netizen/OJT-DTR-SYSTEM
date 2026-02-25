<?php
$pageTitle = "View OJT Students";
include "config/db.php";

// Fetch all students
$students = $conn->query("SELECT * FROM students ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="wrapper">
    <?php include "layout/sidebar.php"; ?>
    <div class="main">
        <?php include "layout/topbar.php"; ?>

        <div class="content">

            <h2>OJT Students</h2>

            <div class="actions" style="margin-bottom:15px;">
                <label>Filter by College / Department:</label>
                <select id="filter_college">
                    <option value="" selected>All</option>
                    <option value="CASTech">CASTech</option>
                    <option value="CAS">CAS</option>
                    <option value="CBEE">CBEE</option>
                    <option value="COED">COED</option>
                    <option value="CoECS">CoECS</option>
                    <option value="CVM">CVM</option>
                </select>

                <button onclick="window.location.href='add_student.php'">Add Student</button>
            </div>

            <table id="students_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Number</th>
                        <th>Name</th>
                        <th>College / Department</th>
                        <th>Program</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $students->fetch_assoc()): ?>
                    <tr data-college="<?= htmlspecialchars(explode(' - ', $row['college_department'])[0]) ?>">
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['student_number'] ?></td>
                        <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                        <td><?= $row['college_department'] ?></td>
                        <td><?= $row['program'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['contact_number'] ?></td>
                        <td><?= $row['start_date'] ?></td>
                        <td><?= $row['end_date'] ?></td>
                        <td>
                            <button class="update-btn" data-id="<?= $row['id'] ?>">Update</button>
                            <button class="delete-btn" data-id="<?= $row['id'] ?>">Delete</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script src="javascript/view_students.js"></script>
</body>
</html>
