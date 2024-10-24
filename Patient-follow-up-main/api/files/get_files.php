<?php
// require '../../includes/auth.php';
// authorize(['admin',"doctor"]);
header("Access-Control-Allow-Origin: *");

// Allow the following methods
header("Access-Control-Allow-Methods: GET, POST,PUT, OPTIONS");

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

// Validate and sanitize the diagnosis_id from the GET request
$diagnosis_id = isset($_GET['diagnosis_id']) ? intval($_GET['diagnosis_id']) : 0;

if ($diagnosis_id <= 0) {
    echo json_encode(["error" => "Invalid diagnosis ID"]);
    exit;
}

// Prepare and execute query
$query = "SELECT * FROM diagnostic_files WHERE diagnosis_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $diagnosis_id);
$stmt->execute();
$result = $stmt->get_result();

$files = [];
while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}

echo json_encode($files);

$stmt->close();
$conn->close();
?>
