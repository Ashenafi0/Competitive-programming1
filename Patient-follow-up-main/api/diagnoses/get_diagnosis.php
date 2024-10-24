<?php
// require '../../includes/auth.php';
// authorize(['admin',"doctor"]);


header("Access-Control-Allow-Origin: *");

// Allow the following methods
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Allow the following headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// If this is a preflight request, respond with 200 OK
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Response for preflight request
    http_response_code(200);
    exit;
}

require '../../includes/dbconn.php';

header('Content-Type: application/json');

// Get the diagnosis ID from the query parameter
$diagnosis_id = isset($_GET['diagnosis_id']) ? intval($_GET['diagnosis_id']) : 0;

if ($diagnosis_id <= 0) {
    echo json_encode(["error" => "Invalid or missing diagnosis ID"]);
    exit;
}

// Prepare and execute
$query = "SELECT * FROM diagnoses WHERE diagnosis_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $diagnosis_id);
$stmt->execute();
$result = $stmt->get_result();
$diagnosis = mysqli_fetch_all($result, MYSQLI_ASSOC);

// $diagnosis = $result->fetch_assoc();

if ($diagnosis) {
    
    echo json_encode($diagnosis);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
