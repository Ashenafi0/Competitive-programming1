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

// Get the visit ID from the query parameter
$visit_id = isset($_GET['visit_id']) ? intval($_GET['visit_id']) : 0;

if ($visit_id <= 0) {
    echo json_encode(["error" => "Invalid or missing visit ID"]);
    exit;
}


// Prepare and execute
$query = "SELECT * FROM diagnoses WHERE visit_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $visit_id);
$stmt->execute();
$result = $stmt->get_result();

$diagnoses = [];
while ($row = $result->fetch_assoc()) {
    $diagnoses[] = $row;
}

echo json_encode($diagnoses);

$stmt->close();
$conn->close();
?>
