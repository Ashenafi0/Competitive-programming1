<?php

// require '../../includes/auth.php';
// authorize(['admin',"doctor"]);
header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// If the request method is OPTIONS, respond with 200 OK
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
require '../../includes/dbconn.php';

header('Content-Type: application/json');

// Extract file ID from the URL
$file_id = isset($_GET['file_id']) ? intval($_GET['file_id']) : 0;

if ($file_id <= 0) {
    echo json_encode(["error" => "Invalid file ID"]);
    exit;
}

// Prepare and execute query to fetch file_path
$query = "SELECT file_path FROM diagnostic_files WHERE file_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $file_id);
$stmt->execute();
$result = $stmt->get_result();
$file = $result->fetch_assoc();

if ($file) {
    $file_path = $file['file_path'];

    // Delete the file from the filesystem
    if (unlink($file_path)) {
        // Delete the file record from the database
        $query = "DELETE FROM diagnostic_files WHERE file_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $file_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => "File deleted successfully"]);
        } else {
            echo json_encode(["error" => $stmt->error]);
        }
    } else {
        echo json_encode(["error" => "Failed to delete file from server"]);
    }
} else {
    echo json_encode(["error" => "File not found"]);
}

$stmt->close();
$conn->close();
?>
