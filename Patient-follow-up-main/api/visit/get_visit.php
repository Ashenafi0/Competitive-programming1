<?php
// require '../../includes/auth.php';
// authorize(['admin',"doctor"]);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
require '../../includes/dbconn.php';

header('Content-Type: application/json');

// Get the visit ID from the query parameter
$visit_id = isset($_GET['visit_id']) ? intval($_GET['visit_id']) : 0;

if ($visit_id <= 0) {
    echo json_encode(["error" => "Invalid or missing visit ID"]);
    exit;
}

// Prepare and execute
$query = "SELECT * FROM visits WHERE visit_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $visit_id);
$stmt->execute();
$result = $stmt->get_result();
$visit = $result->fetch_assoc();

if ($visit) {
    echo json_encode($visit);
} else {
    echo json_encode(["error" => "Visit not found"]);
}

$stmt->close();
$conn->close();
?>
