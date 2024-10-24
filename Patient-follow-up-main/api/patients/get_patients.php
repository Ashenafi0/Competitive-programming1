<?php
// require '../../includes/auth.php';
// authorize(['admin',"doctor"]);
require '../../includes/dbconn.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// header('Content-Type: application/json');

// Prepare and execute the query to fetch all patients
$stmt = $conn->prepare("SELECT * FROM patients");

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $patients = [];
    
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
    
    echo json_encode($patients);
} else {
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
