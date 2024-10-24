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

// Extract file ID from the URL
$file_id = isset($_GET['file_id']) ? intval($_GET['file_id']) : 0;

if ($file_id <= 0) {
    echo json_encode(["error" => "Invalid file ID"]);
    exit;
}

// Prepare and execute query to fetch file details
$query = "SELECT * FROM diagnostic_files WHERE file_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $file_id);
$stmt->execute();
$result = $stmt->get_result();
$file = $result->fetch_assoc();

if ($file) {
    // Set headers to download the file
    header('Content-Type: ' . $file['file_type']);
    header('Content-Disposition: attachment; filename="' . basename($file['file_name']) . '"');
    readfile($file['file_path']);
} else {
    echo json_encode(["error" => "File not found"]);
}

$stmt->close();
$conn->close();
?>
