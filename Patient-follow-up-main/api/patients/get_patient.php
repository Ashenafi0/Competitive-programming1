<?php
// require '../../includes/auth.php';
// authorize(['admin']);
require '../../includes/dbconn.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// header('Content-Type: application/json');

// Extract patient ID from the URL query parameters
$patient_id = isset($_GET['patient_id']) ? intval($_GET['patient_id']) : 0;

if ($patient_id <= 0) {
    echo json_encode(["error" => "Invalid patient ID"]);
    exit;
}

// Prepare and execute SQL query
$query = "SELECT * FROM patients WHERE patient_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $patient_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
    if ($patient) {
        echo json_encode($patient);
    } else {
        echo json_encode(["error" => "Patient not found"]);
    }
} else {
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
