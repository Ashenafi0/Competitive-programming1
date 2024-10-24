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

// Get the diagnosis ID from the query parameter
$diagnosis_id = isset($_GET['diagnosis_id']) ? intval($_GET['diagnosis_id']) : 0;

if ($diagnosis_id <= 0) {
    echo json_encode(["error" => "Invalid or missing diagnosis ID"]);
    exit;
}

// Build the SQL query dynamically based on provided fields
$fields = [];
$types = '';
$params = [];

if (isset($input['diagnosis_description'])) {
    $fields[] = 'diagnosis_description = ?';
    $types .= 's';
    $params[] = $input['diagnosis_description'];
}

// if (isset($input['visit_id'])) {
//     $fields[] = 'visit_id = ?';
//     $types .= 'i';
//     $params[] = $input['visit_id'];
// }

if (count($fields) == 0) {
    echo json_encode(["error" => "No fields to update"]);
    exit;
}

// Add the diagnosis_id to the parameters array
$types .= 'i';
$params[] = $diagnosis_id;

$query = "UPDATE diagnoses SET " . implode(', ', $fields) . " WHERE diagnosis_id = ?";

// Prepare and bind
$stmt = $conn->prepare($query);

// Bind parameters dynamically
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => "Diagnosis updated successfully"]);
    } else {
        echo json_encode(["error" => "No changes made or diagnosis not found"]);
    }
} else {
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
