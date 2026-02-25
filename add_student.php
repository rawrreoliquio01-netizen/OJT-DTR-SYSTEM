<?php
$pageTitle = "Add OJT Student";
include "config/db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add OJT Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="wrapper">
    <?php include "layout/sidebar.php"; ?>
    <div class="main">
        <?php include "layout/topbar.php"; ?>

        <div class="content">

            <form action="save_student.php" method="POST">
                <h2>Add OJT Student</h2>

                <label>Student Number</label>
                <input type="text" name="student_number" required>

                <label>First Name</label>
                <input type="text" name="first_name" required>

                <label>Last Name</label>
                <input type="text" name="last_name" required>

                <label>College / Department</label>
                <select name="college_select" id="college_select" required>
                    <option value="" disabled selected>Select College / Department</option>
                    <optgroup label="College of Agricultural Systems and Technology (CASTech)">
                        <option value="CASTech">CASTech</option>
                    </optgroup>
                    <optgroup label="College of Arts and Sciences (CAS)">
                        <option value="CAS">CAS</option>
                    </optgroup>
                    <optgroup label="College of Business, Economics and Entrepreneurship (CBEE)">
                        <option value="CBEE">CBEE</option>
                    </optgroup>
                    <optgroup label="College of Education (COED)">
                        <option value="COED">COED</option>
                    </optgroup>
                    <optgroup label="College of Engineering and Computer Studies (CoECS)">
                        <option value="CoECS">CoECS</option>
                    </optgroup>
                    <optgroup label="College of Veterinary Medicine (CVM)">
                        <option value="CVM">CVM</option>
                    </optgroup>
                </select>

                <label>Program</label>
                <select name="program" id="program_select" required>
                    <option value="" disabled selected>Select Program</option>
                    <!-- Programs per college omitted for brevity; same as original -->
                </select>

                <label>Email</label>
                <input type="email" name="email">

                <label>Contact Number</label>
                <input type="text" name="contact_number">

                <label>Start Date</label>
                <input type="date" name="start_date">

                <label>Total OJT Hours Required</label>
                <input type="number" name="total_hours" min="1" required>

                <label>Remaining Hours</label>
                <input type="number" name="remaining_hours" min="0" required>

                <label>Company Assigned</label>
                <input type="text" name="company" required>

                <label>Department / Office Assigned</label>
                <input type="text" name="department_office" required>

                <button type="submit">Save Student</button>
            </form>

        </div>
    </div>
</div>

<script src="javascript/student.js"></script>
</body>
</html>