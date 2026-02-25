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
                    
                    <!-- CASTech Programs -->
                    <option value="BS Agriculture" data-college="CASTech">BS Agriculture</option>
                    <option value="BS Forestry" data-college="CASTech">BS Forestry</option>
                    <option value="BS Fisheries" data-college="CASTech">BS Fisheries</option>
                    <option value="BS Agricultural Technology" data-college="CASTech">BS Agricultural Technology</option>
                    
                    <!-- CAS Programs -->
                    <option value="BA English Language Studies" data-college="CAS">BA English Language Studies</option>
                    <option value="BS Biology" data-college="CAS">BS Biology</option>
                    <option value="BS Mathematics" data-college="CAS">BS Mathematics</option>
                    
                    <!-- CBEE Programs -->
                    <option value="BS Agricultural Business" data-college="CBEE">BS Agricultural Business</option>
                    <option value="BS Entrepreneurship" data-college="CBEE">BS Entrepreneurship</option>
                    <option value="BS Hospitality Management" data-college="CBEE">BS Hospitality Management</option>
                    <option value="BS Food Technology" data-college="CBEE">BS Food Technology</option>
                    
                    <!-- COED Programs -->
                    <option value="BEEd – Elementary Education" data-college="COED">BEEd – Elementary Education</option>
                    <option value="BSEd – Secondary Education" data-college="COED">BSEd – Secondary Education</option>
                    <option value="BPED – Physical Education" data-college="COED">BPED – Physical Education</option>
                    <option value="BTVTEd – Technology & Livelihood Education" data-college="COED">BTVTEd – Technology & Livelihood Education</option>
                    
                    <!-- CoECS Programs -->
                    <option value="BS Agricultural & Biosystems Engineering" data-college="CoECS">BS Agricultural & Biosystems Engineering</option>
                    <option value="BS Civil Engineering" data-college="CoECS">BS Civil Engineering</option>
                    <option value="BS Computer Engineering" data-college="CoECS">BS Computer Engineering</option>
                    <option value="BS Information Technology" data-college="CoECS">BS Information Technology</option>
                    <option value="BS Geodetic Engineering" data-college="CoECS">BS Geodetic Engineering</option>
                    
                    <!-- CVM Programs -->
                    <option value="Doctor of Veterinary Medicine" data-college="CVM">Doctor of Veterinary Medicine</option>
                </select>

                <label>Email</label>
                <input type="email" name="email">

                <label>Contact Number</label>
                <input type="text" name="contact_number">

                <label>Start Date</label>
                <input type="date" name="start_date" required>

                <label>Total OJT Hours Needed</label>
                <input type="number" name="hrs_needed" min="1" required>

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