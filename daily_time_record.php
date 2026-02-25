<?php
session_start();
include "config/db.php";
date_default_timezone_set('Asia/Manila');

$student_number = $_SESSION['student_number'] ?? '';
$student_name   = $_SESSION['student_name'] ?? '';

if (!$student_number) {
    header("Location: index.php");
    exit;
}

$date_today = date('Y-m-d');
$overtime_limit = "18:15:00";

/* ==========================================
   HANDLE TIME OUT + ACCOMPLISHMENT SAVE
========================================== */
if (isset($_POST['session_id']) && isset($_POST['record_id']) && isset($_POST['accomplishment'])) {

    $record_id  = intval($_POST['record_id']);
    $accomplishment = trim($_POST['accomplishment']);

    // Ensure date is today before saving
    $check_date = $conn->query("SELECT record_date FROM time_records WHERE id='$record_id'")->fetch_assoc()['record_date'];
    if ($check_date === $date_today) {
        $stmt = $conn->prepare("UPDATE time_records SET accomplishment=? WHERE id=?");
        $stmt->bind_param("si", $accomplishment, $record_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: daily_time_record.php");
    exit;
}

/* Ensure record exists */
$check = $conn->prepare("SELECT * FROM time_records WHERE student_number=? AND record_date=?");
$check->bind_param("ss", $student_number, $date_today);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    $insert = $conn->prepare("INSERT INTO time_records (student_number, student_name, record_date) VALUES (?, ?, ?)");
    $insert->bind_param("sss", $student_number, $student_name, $date_today);
    $insert->execute();
    $record_id = $insert->insert_id;
} else {
    $row = $result->fetch_assoc();
    $record_id = $row['id'];
}

$records = $conn->query("SELECT * FROM time_records WHERE student_number='$student_number' ORDER BY record_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daily Time Record</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container{ padding: 20px; }
        .table-container { overflow-x: auto; margin-bottom: 20px; }
        .table-container table { min-width: 900px; border-collapse: collapse; width:100%; background:white; }
        .table-container th, .table-container td { padding: 12px; border: 1px solid #ddd; text-align: left; }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 20px;
            width: 400px;
            border-radius: 8px;
            position: relative;
        }

        .btn-timeout {
            background: #dc3545;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-timeout:disabled {
            background: #aaa;
            cursor: not-allowed;
        }

        textarea {
            width: 100%;
            height: 100px;
            margin-top: 10px;
            padding: 10px;
            box-sizing: border-box;
            resize: none;
        }

        .overtime {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="layout">
    <?php include "layout/student_sidebar.php"; ?> 
    <div class="main-content">
        <?php include "layout/student_topbar.php"; ?>

        <div class="container">
            <button onclick="window.location.href='dtr_report.php'" class="btn-generate-report">
                Generate DTR Record
            </button>

            <div class="prev">
                <h1>Previous Records</h1>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>AM Sessions</th>
                            <th>PM Sessions</th>
                            <th>Overtime Sessions</th>
                            <th>Total Hours</th>
                            <th>Accomplishment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($r = $records->fetch_assoc()): ?>
                            <?php
                            $dailySessions = $conn->query("SELECT * FROM time_sessions WHERE record_id='{$r['id']}' ORDER BY id ASC");

                            $amList = [];
                            $pmList = [];
                            $overtimeList = [];
                            $totalSeconds = 0;
                            $active_session_id = null;

                            while($s = $dailySessions->fetch_assoc()){

                                if($s['time_in'] && $s['time_out']){

                                    $timeIn  = $s['time_in'];
                                    $timeOut = $s['time_out'];

                                    // Regular duration
                                    $regularEnd = $timeOut;

                                    if($timeOut > $overtime_limit){

                                        if($timeIn < $overtime_limit){
                                            $regularEnd = $overtime_limit;

                                            $overtimeList[] =
                                                date('h:i A', strtotime($overtime_limit)) .
                                                " - " .
                                                date('h:i A', strtotime($timeOut));
                                        } else {
                                            $regularEnd = null;

                                            $overtimeList[] =
                                                date('h:i A', strtotime($timeIn)) .
                                                " - " .
                                                date('h:i A', strtotime($timeOut));
                                        }
                                    }

                                    if($regularEnd){
                                        $duration = strtotime($regularEnd) - strtotime($timeIn);
                                        $totalSeconds += $duration;

                                        $formatted = date('h:i A', strtotime($timeIn)) .
                                                     " - " .
                                                     date('h:i A', strtotime($regularEnd));

                                        if($s['period']=='AM') $amList[] = $formatted;
                                        if($s['period']=='PM') $pmList[] = $formatted;
                                    }

                                } else {
                                    $active_session_id = $s['id'];
                                }
                            }

                            $totalHours = floor($totalSeconds / 3600);
                            $totalMinutes = floor(($totalSeconds % 3600) / 60);

                            $is_today = ($r['record_date'] === $date_today);
                            ?>
                            <tr>
                                <td><?= $r['record_date']; ?></td>
                                <td><?= !empty($amList) ? implode("<br>", $amList) : '-'; ?></td>
                                <td><?= !empty($pmList) ? implode("<br>", $pmList) : '-'; ?></td>
                                <td class="overtime">
                                    <?= !empty($overtimeList) ? implode("<br>", $overtimeList) : '-'; ?>
                                </td>
                                <td><?= $totalHours ?>h <?= $totalMinutes ?>m</td>
                                <td><?= htmlspecialchars($r['accomplishment'] ?? '-'); ?></td>
                                <td>
                                    <button class="btn-timeout" 
                                            <?= $is_today ? "" : "disabled title='Cannot edit past records'" ?>
                                            onclick="openTimeoutModal(<?= $active_session_id ?? 0 ?>, <?= $r['id'] ?>, '<?= htmlspecialchars(addslashes($r['accomplishment'] ?? '')) ?>')">
                                        Write / Edit
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- TIMEOUT MODAL -->
<div id="timeoutModal" class="modal">
    <div class="modal-content">
        <h3>Write / Edit Accomplishment</h3>
        <form method="POST" id="timeoutForm">
            <input type="hidden" name="session_id" id="modal_session_id">
            <input type="hidden" name="record_id" id="modal_record_id">

            <textarea name="accomplishment" id="modal_accomplishment" required placeholder="What did you do today?"></textarea>

            <br><br>

            <button type="submit" class="btn-timeout">Save</button>
            <button type="button" onclick="closeModal()" style="background:#6c757d; color:white; border:none; padding:8px 12px; border-radius:4px;">Cancel</button>
        </form>
    </div>
</div>

</body>
</html>