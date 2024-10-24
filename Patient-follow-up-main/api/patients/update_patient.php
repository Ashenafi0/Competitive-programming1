<?php
// require '../../includes/auth.php';
// authorize(['admin']);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
require '../../includes/dbconn.php';

header('Content-Type: application/json');

// Check the request method
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode(["error" => "Invalid request method"]);
    exit;
}

// Retrieve the JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(["error" => "Invalid JSON input"]);
    exit;
}

// Retrieve patient_id from the input
$patient_id = isset($_GET['patient_id']) ? intval($_GET['patient_id']) : 0;

if ($patient_id <= 0) {
    echo json_encode(["error" => "Invalid patient ID"]);
    exit;
}

// Build the SQL query dynamically based on provided fields
$fields = [];
$types = '';
$params = [];

// Example fields that can be updated, adjust as needed
if (isset($input['first_name'])) {
    $fields[] = 'first_name = ?';
    $types .= 's';
    $params[] = $input['first_name'];
}
if (isset($input['last_name'])) {
    $fields[] = 'last_name = ?';
    $types .= 's';
    $params[] = $input['last_name'];
}
if (isset($input['date_of_birth'])) {
    $fields[] = 'date_of_birth = ?';
    $types .= 's';
    $params[] = $input['date_of_birth'];
}
if (isset($input['gender'])) {
    $fields[] = 'gender = ?';
    $types .= 's';
    $params[] = $input['gender'];
}
if (isset($input['email'])) {
    $fields[] = 'email = ?';
    $types .= 's';
    $params[] = $input['email'];
}
if (isset($input['contact_number'])) {
    $fields[] = 'contact_number = ?';
    $types .= 's';
    $params[] = $input['contact_number'];
}
if (isset($input['address'])) {
    $fields[] = 'address = ?';
    $types .= 's';
    $params[] = $input['address'];
}
if (isset($input['emergency_contact_name'])) {
    $fields[] = 'emergency_contact_name = ?';
    $types .= 's';
    $params[] = $input['emergency_contact_name'];
}
if (isset($input['emergency_contact_number'])) {
    $fields[] = 'emergency_contact_number = ?';
    $types .= 's';
    $params[] = $input['emergency_contact_number'];
}

if (count($fields) == 0) {
    echo json_encode(["error" => "No fields to update"]);
    exit;
}

$query = "UPDATE patients SET " . implode(', ', $fields) . " WHERE patient_id = ?";

// Prepare and bind
$stmt = $conn->prepare($query);

// Add the patient_id to the parameters array
$types .= 'i';
$params[] = $patient_id;

// Bind parameters dynamically
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => "Patient updated successfully"]);
    } else {
        echo json_encode(["error" => "No changes made or patient not found"]);
    }
} else {
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
