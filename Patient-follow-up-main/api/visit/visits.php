<?php
// session_start();
// require '../../includes/auth.php';
// authorize(['admin',"doctor"]);
require '../../includes/dbconn.php'; 

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

header('Content-Type: application/json');

function registerVisit($data, $conn, $patient_id) {
    // Prepare the statement
    $query = "INSERT INTO visits (patient_id, reason_for_visit, visited_date) 
              VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'sss', 
        $patient_id,
        $data->reason_for_visit,
        $data->visited_date
    );

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        http_response_code(200);
        echo json_encode(['message' => 'Visit registered successfully']);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        echo json_encode(['message' => 'Unable to register visit: ' . mysqli_error($conn)]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive JSON data and decode it
    $data = json_decode(file_get_contents("php://input"));
    $patient_id = isset($_GET["patient_id"]) ? intval($_GET["patient_id"]) : 0;

    if ($patient_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    // Register patient and return JSON response
    registerVisit($data, $conn, $patient_id);
}
?>
