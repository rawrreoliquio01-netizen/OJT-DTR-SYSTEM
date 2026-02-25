<?php
include "config/db.php";

// Sample supervisors data
$supervisors = [
    ['name' => 'Dr. Juan Dela Cruz', 'email' => 'juan.delacruz@psau.edu.ph'],
    ['name' => 'Prof. Maria Santos', 'email' => 'maria.santos@psau.edu.ph'],
    ['name' => 'Engr. Carlos Reyes', 'email' => 'carlos.reyes@psau.edu.ph'],
    ['name' => 'Dr. Ana Martinez', 'email' => 'ana.martinez@psau.edu.ph'],
    ['name' => 'Prof. Roberto Garcia', 'email' => 'roberto.garcia@psau.edu.ph']
];

// Create supervisors table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS supervisors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
)");

// Insert sample supervisors
foreach ($supervisors as $supervisor) {
    $check = $conn->prepare("SELECT id FROM supervisors WHERE name=?");
    $check->bind_param("s", $supervisor['name']);
    $check->execute();
    
    if ($check->get_result()->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO supervisors (name, email) VALUES (?, ?)");
        $insert->bind_param("ss", $supervisor['name'], $supervisor['email']);
        $insert->execute();
        echo "Added: " . $supervisor['name'] . "\n";
    } else {
        echo "Already exists: " . $supervisor['name'] . "\n";
    }
}

echo "\nSample supervisors added successfully!";
?>
