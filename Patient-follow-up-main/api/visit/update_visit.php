<?php

// require '../../includes/auth.php';
// authorize(['admin',"doctor"]);
require '../../includes/dbconn.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

header('Content-Type: application/json');

header('Content-Type: application/json');

$input = (array) json_decode(file_get_contents('php://input'), TRUE);

// Get the visit ID from the query parameter
$visit_id = isset($_GET['visit_id']) ? intval($_GET['visit_id']) : 0;

if ($visit_id <= 0) {
    echo json_encode(["error" => "Invalid or missing visit ID"]);
    exit;
}

// Build the SQL query dynamically based on provided fields
$fields = [];
$types = '';
$params = [];

if (isset($input['reason_for_visit'])) {
    $fields[] = 'reason_for_visit = ?';
    $types .= 's';
    $params[] = $input['reason_for_visit'];
}
if (isset($input['visited_date'])) {
    $fields[] = 'visited_date = ?';
    $types .= 's';
    $params[] = $input['visited_date'];
}
if (isset($input['patient_id'])) {
    $fields[] = 'patient_id = ?';
    $types .= 'i';
    $params[] = $input['patient_id'];
}

if (count($fields) == 0) {
    echo json_encode(["error" => "No fields to update"]);
    exit;
}

// Add the visit_id to the parameters array
$types .= 'i';
$params[] = $visit_id;

$query = "UPDATE visits SET " . implode(', ', $fields) . " WHERE visit_id = ?";

// Prepare and bind
$stmt = $conn->prepare($query);

// Bind parameters dynamically
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => "Visit updated successfully"]);
    } else {
        echo json_encode(["error" => "No changes made or visit not found"]);
    }
} else {
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
