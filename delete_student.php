<?php
include "config/db.php";

$id = $_GET['id'] ?? 0;
$id = intval($id);

if($id > 0){
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        echo "Student deleted successfully";
    } else {
        echo "Error deleting student";
    }
} else {
    echo "Invalid student ID";
}
?>
