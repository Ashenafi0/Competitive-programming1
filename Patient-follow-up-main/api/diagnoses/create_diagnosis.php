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

$input = (array) json_decode(file_get_contents('php://input'), TRUE);

// Get the visit ID from the query parameter
$visit_id = isset($_GET['visit_id']) ? intval($_GET['visit_id']) : 0;

if ($visit_id <= 0) {
    echo json_encode(["error" => "Invalid or missing visit ID"]);
    exit;
}
// Prepare and bind
$query = "INSERT INTO diagnoses (visit_id, diagnosis_description) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $visit_id, $input['diagnosis_description']);

if ($stmt->execute()) {
    $input['diagnosis_id'] = $stmt->insert_id;
    echo json_encode($input);
} else {
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
