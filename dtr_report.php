<?php
session_start();
include "config/db.php";

// Check if student is logged in
if (!isset($_SESSION['student_number'])) {
    header("Location: index.php");
    exit();
}

$student_number = $_SESSION['student_number'];
$student_name = $_SESSION['student_name'] ?? '';

// Get student information (removed end_date, hrs_needed, remaining_hours)
$stmt = $conn->prepare("SELECT first_name, last_name, company, department_office, email, contact_number, start_date FROM students WHERE student_number = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $student_number);
$stmt->execute();
$student_info = $stmt->get_result()->fetch_assoc();
$stmt->close();

$date_from = $_GET['date_from'] ?? '';
$date_to   = $_GET['date_to'] ?? '';

$where = "WHERE tr.student_number = '$student_number'";
if ($date_from && $date_to) {
    $where .= " AND tr.record_date BETWEEN '$date_from' AND '$date_to'";
}

$sql = "SELECT 
    DAY(tr.record_date) as day,
    GROUP_CONCAT(DISTINCT DATE_FORMAT(ts1.time_in, '%h:%i') ORDER BY ts1.time_in SEPARATOR '\n') as morning_in,
    GROUP_CONCAT(DISTINCT DATE_FORMAT(ts1.time_out, '%h:%i') ORDER BY ts1.time_out SEPARATOR '\n') as morning_out,
    GROUP_CONCAT(DISTINCT DATE_FORMAT(ts2.time_in, '%h:%i') ORDER BY ts2.time_in SEPARATOR '\n') as afternoon_in,
    GROUP_CONCAT(DISTINCT DATE_FORMAT(ts2.time_out, '%h:%i') ORDER BY ts2.time_out SEPARATOR '\n') as afternoon_out,
    GROUP_CONCAT(DISTINCT DATE_FORMAT(ts3.time_in, '%h:%i') ORDER BY ts3.time_in SEPARATOR '\n') as overtime_in,
    GROUP_CONCAT(DISTINCT DATE_FORMAT(ts3.time_out, '%h:%i') ORDER BY ts3.time_out SEPARATOR '\n') as overtime_out,
    GROUP_CONCAT(DISTINCT tr.accomplishment SEPARATOR '\n') as accomplishment,
    GROUP_CONCAT(DISTINCT tr.supervisor_esig SEPARATOR '\n') as supervisor_signature,
    tr.id as record_id,
    tr.record_date
FROM time_records tr
LEFT JOIN time_sessions ts1 ON tr.id = ts1.record_id AND ts1.period = 'AM'
LEFT JOIN time_sessions ts2 ON tr.id = ts2.record_id AND ts2.period = 'PM'
LEFT JOIN time_sessions ts3 ON tr.id = ts3.record_id AND ts3.period = 'PM' AND ts3.time_in > '17:00:00'
$where 
GROUP BY tr.record_date
ORDER BY tr.record_date ASC";

$result = mysqli_query($conn, $sql);

$dataRows = [];
$overtime_limit = "18:15:00";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        // ===========================
        // CALCULATE DAILY TOTAL HOURS
        // ===========================
        $sessions = $conn->query("SELECT * FROM time_sessions WHERE record_id='{$row['record_id']}' ORDER BY id ASC");
        $totalSeconds = 0;

        while($s = $sessions->fetch_assoc()){
            if($s['time_in'] && $s['time_out']){
                $timeIn = $s['time_in'];
                $timeOut = $s['time_out'];

                $regularEnd = $timeOut;

                if($timeOut > $overtime_limit){
                    if($timeIn < $overtime_limit){
                        $regularEnd = $overtime_limit;
                    } else {
                        $regularEnd = null;
                    }
                }

                if($regularEnd){
                    $duration = strtotime($regularEnd) - strtotime($timeIn);
                    $totalSeconds += $duration;
                }
            }
        }

        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $row['daily_total'] = $hours . "h " . $minutes . "m";

        $dataRows[] = $row;
    }
}

function truncate($text, $chars = 180) {
    if (strlen($text) <= $chars) return $text;
    return substr($text, 0, $chars) . "...";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>OJT Daily Time Record Report</title>
<style>
@page { 
    size: A4 landscape; 
    margin: 5mm;
}
html, body { height: 100%; margin: 0; padding: 0; font-family: Arial; }
body { background: #525659; display: flex; justify-content: center; padding-top: 20px; }
.page-canvas { width: 297mm; background: #fff; padding: 8mm; box-shadow: 0 0 15px rgba(0,0,0,0.3); box-sizing: border-box; }
table.tbl-main { width: 100%; border-collapse: collapse; }
thead { display: table-header-group; }
tfoot { display: table-footer-group; padding-top: -19px; }
.tbl-main th, .tbl-main td { border: 1px solid #000; font-size: 9pt; word-wrap: break-word; text-align: center; vertical-align: middle; white-space: normal; line-height: 10px; height: 20px; overflow: hidden; text-overflow: ellipsis; }
.tbl-main td.accomplishment { font-size: 6pt; white-space: normal; word-break: break-word; line-height: 9px; }
.tbl-main td.signature { font-size: 7pt; white-space: normal; word-break: break-word; line-height: 9px; }
.tbl-main td[contenteditable="true"] { outline: none; border: 1px solid #000; background: #fff; line-height: 20px; }
.tbl-main th { background: #eaeaea; font-weight: bold; line-height: 12px; border: 2px solid #000 !important; }
.days, .day, .total { line-height: 20px !important; }
.days      { width: 3%; }
.day      { width: 8%; }
.total      { width: 4%; }
.accomplishment { width: 45%; }
.signature { width: 31%; }
.iso-header { width: 100%; }
.header-title { font-size: 14pt; font-weight: bold; text-align: center; background: #eaeaea; border: 1px solid #000; border-bottom: none; padding: 6px; margin-top: 5px; }
.iso-footer-content { font-size: 8pt; display: flex; justify-content: space-between; }
.print-btn { position: fixed; top: 20px; right: 40px; z-index: 100; }
.print-btn button { padding: 10px 20px; cursor: pointer; background: #b9a80eff; color: white; border: none; border-radius: 5px; font-weight: bold; }
@media print {
    body { background: none; padding: 0; }
    .print-btn { display: none; }
    .page-canvas { width: 100%; box-shadow: none; margin: 0; padding: 5mm; }
    tr { page-break-inside: avoid; } 
}
</style>
</head>
<body>

<div class="print-btn">
    <button onclick="window.print()"> 🖨 Print Report </button>
</div>

<div class="page-canvas">
    <table class="tbl-main">
        <thead>
            <tr>
                <td colspan="10" style="border: none; padding: 0;">
                    <div class="iso-header">
                        <table style="width:100%; border-collapse: collapse;">
                            <tr>
                                <td width="80" style="border: none;">
                                    <img src="assets/logo.png" height="85">
                                </td>
                                <td style="border: none; text-align: left; vertical-align: middle; padding-bottom: -10px">
                                    <span style="font-size: 12pt;"> PAMPANGA STATE AGRICULTURAL UNIVERSITY </span><br>
                                    <span style="font-size: 10pt; line-height: 1.2rem;"><b> College of Engineering and Computer Studies </b></span>
                                    <hr style="border: 1px solid black; margin-top: 8px;">
                                </td>
                            </tr>
                        </table>
                        <table style="width:100%; border-collapse: collapse; margin-top: -20px;">
                            <tr>
                                <td style="border: none; text-align: center; vertical-align: middle; padding: 2px;">
                                    <span style="font-size: 12pt ;"> <b >DAILY TIME RECORD</b> </span><br>
                                    <span style="font-size: 10pt; line-height: 1.4rem;">FOR THE MONTH OF__________20_____</span>
                                </td>
                            </tr>
                        </table>
                        <table style="width:100%; border-collapse: collapse; margin-top: 10px;">
                            <tr>
                                <td style="border: none; text-align: left; vertical-align: middle; width: 50%;">
                                    <span style="font-size: 10pt;"> <b>Student Name: </b><b><u><?= strtoupper(htmlspecialchars($student_info['first_name'] . ' ' . $student_info['last_name'] ?? '________________________________________')) ?></u></b> </span>
                                </td>
                                <td style="border: none; text-align: left; vertical-align: middle; width: 50%;">
                                    <span style="font-size: 10pt;"> <b>Company: </b><b><u><?= strtoupper(htmlspecialchars($student_info['company'] ?? '____________________________________________________')) ?></u></b> </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; text-align: left; vertical-align: middle; width: 50%;">
                                    <span style="font-size: 10pt;"> <b>Course, Yr. & Sec: </b><b><u></u></b> </span>
                                </td>
                                <td style="border: none; text-align: left; vertical-align: middle; width: 50%;">
                                    <span style="font-size: 10pt;"> <b>Department/Office: </b><b><u><?= strtoupper(htmlspecialchars($student_info['department_office'] ?? '_____________________________________________')) ?></u></b> </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <th class="col-ctrl days" rowspan="2"> Days </th>
                <th class="col-date day" colspan="2"> MORNING </th>
                <th class="col-date day" colspan="2"> AFTERNOON </th>
                <th class="col-req-type day" colspan="2"> OVERTIME </th>
                <th class="col-user-type total" rowspan="2"> Daily Total </th>
                <th class="col-name accomplishment" rowspan="2"> ACCOMPLISHMENT </th>
                <th class="col-problem signature" rowspan="2"> Signature of Supervisor/Manager </th>
            </tr>
            <tr>
                <th class="col-date"> IN </th>
                <th class="col-date"> OUT </th>
                <th class="col-date"> IN </th>
                <th class="col-date"> OUT </th>
                <th class="col-req-type"> IN </th>
                <th class="col-req-type"> OUT </th>
            </tr>
        </thead>

        <tbody>
            <?php 
            $dataCount = count($dataRows);
            $maxRows = 15;
            $dataRowsToShow = min($dataCount, $maxRows);
            
            for ($i = 0; $i < $dataRowsToShow; $i++): 
                $row = $dataRows[$i];
            ?>
            <tr>
                <td><?= htmlspecialchars($row['day'] ?? '') ?></td>
                <td><?= nl2br(htmlspecialchars($row['morning_in'] ?? '')) ?></td>
                <td><?= nl2br(htmlspecialchars($row['morning_out'] ?? '')) ?></td>
                <td><?= nl2br(htmlspecialchars($row['afternoon_in'] ?? '')) ?></td>
                <td><?= nl2br(htmlspecialchars($row['afternoon_out'] ?? '')) ?></td>
                <td><?= nl2br(htmlspecialchars($row['overtime_in'] ?? '')) ?></td>
                <td><?= nl2br(htmlspecialchars($row['overtime_out'] ?? '')) ?></td>
                <td><?= htmlspecialchars($row['daily_total'] ?? '') ?></td>
                <td class="accomplishment" style="text-align: left;"><?= nl2br(htmlspecialchars($row['accomplishment'] ?? '')) ?></td>
                <td class="signature"><?= nl2br(htmlspecialchars($row['supervisor_signature'] ?? '')) ?></td>
            </tr>
            <?php endfor; ?>
            
            <?php 
            $emptyRows = $maxRows - $dataRowsToShow;
            for ($i = 1; $i <= $emptyRows; $i++): 
            ?>
            <tr>
                <td contenteditable="false"></td>
                <td contenteditable="false"></td>
                <td contenteditable="false"></td>
                <td contenteditable="false"></td>
                <td contenteditable="false"></td>
                <td contenteditable="false"></td>
                <td contenteditable="false"></td>
                <td contenteditable="false"></td>
                <td class="accomplishment" contenteditable="true" style="text-align: left;"></td>
                <td class="signature" contenteditable="true"></td>
            </tr>
            <?php endfor; ?>
        </tbody>

        <tfoot style="border: none; padding: 0; ">
            <tr style="border: none; padding: 0; margin-top: -10px !important">
                <td colspan="10" style="border: none; padding: 0; margin-top: -10px !important">
                    <div class="iso-footer-content">
                        <span><b> I hereby certify that the above records are true and correct</b> </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="10" style="border: none; padding: 0;">
                    <div class="iso-footer-content">
                        <span> PSAU-MIU-SF-03 | 06 (01-30-26) </span>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

</body>
</html>