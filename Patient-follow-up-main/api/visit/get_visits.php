<?php
// require '../../includes/auth.php';
// authorize(['admin',"doctor"]);
require '../../includes/dbconn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

header('Content-Type: application/json');

// Get the patient ID from the query parameter
$patient_id = isset($_GET['patient_id']) ? intval($_GET['patient_id']) : 0;

if ($patient_id <= 0) {
    echo json_encode(["error" => "Invalid or missing patient ID"]);
    exit;
}

// Prepare and execute
$query = "SELECT * FROM visits WHERE patient_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $patient_id);
$stmt->execute();
$result = $stmt->get_result();

$visits = [];
while ($row = $result->fetch_assoc()) {
    $visits[] = $row;
}

echo json_encode($visits);

$stmt->close();
$conn->close();
?>
