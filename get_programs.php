
<?php
include "config/db.php";

$college = $_GET['college'] ?? '';

if($college){
    $stmt = $conn->prepare("SELECT program FROM colleges_programs WHERE college_department = ? ORDER BY program ASC");
    $stmt->bind_param("s", $college);
    $stmt->execute();
    $result = $stmt->get_result();

    $programs = [];
    while($row = $result->fetch_assoc()){
        $programs[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($programs);
}
?>
