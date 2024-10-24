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

// Get the diagnosis ID from the query parameter
$diagnosis_id = isset($_GET['diagnosis_id']) ? intval($_GET['diagnosis_id']) : 0;

if ($diagnosis_id <= 0) {
    echo json_encode(["error" => "Invalid or missing diagnosis ID"]);
    exit;
}

// Check if a file is uploaded
if (!isset($_FILES['file'])) {
    echo json_encode(["error" => "No file uploaded"]);
    exit;
}

$file = $_FILES['file'];
$file_name = basename($file['name']);
$file_type = $file['type'];
// $upload_dir = '../uploads/';
$file_path =   $file_name;

// Move the uploaded file to the uploads directory
if (move_uploaded_file($file['tmp_name'], $file_path)) {
    // Prepare and bind
    $query = "INSERT INTO diagnostic_files (diagnosis_id, file_type, file_name, file_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isss', $diagnosis_id, $file_type, $file_name, $file_path);

    if ($stmt->execute()) {
        echo json_encode(["success" => "File uploaded successfully", "file_id" => $stmt->insert_id]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Failed to upload file"]);
}

$conn->close();
?>
