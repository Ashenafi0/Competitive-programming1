<?php
// session_start();
// require '../includes/auth.php';
// authorize(['admin',"doctor"]);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

header('Content-Type: application/json');
require '../includes/dbconn.php'; 

function updateTreatment($data, $conn, $treatment_id) {
    // Prepare the update statement
    $query = "UPDATE treatments
              SET treatment_type = ?, treatment_description = ?
              WHERE treatment_id = ?";

    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, 'ssi', 
        $data->treatment_type, 
        $data->treatment_description, 
        $treatment_id
    );

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        http_response_code(200);
        echo json_encode(['message' => 'Treatment updated successfully']);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        echo json_encode(['message' => 'Unable to update treatment: ' . mysqli_error($conn)]);
    }
}


function retrieveTreatment( $conn, $treatment_id) 
{

// Prepare the statement
    $query = "SELECT treatment_id,visit_id, treatment_type,treatment_description FROM treatments WHERE treatment_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind the visit_id parameter
    mysqli_stmt_bind_param($stmt, 'i', $treatment_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $treatments = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        // Return treatments as JSON
        http_response_code(200);
        echo json_encode($treatments);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        echo json_encode(['message' => 'Unable to retrieve treatments: ' . mysqli_error($conn)]);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Assuming you receive JSON data and decode it
    $data = json_decode(file_get_contents("php://input"));
    $treatment_id = isset($_GET["treatment_id"]) ? intval($_GET["treatment_id"]) : 0;

    if ($treatment_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    // Register patient and return JSON response
    updateTreatment($data, $conn, $treatment_id);
}
elseif($_SERVER['REQUEST_METHOD'] === 'GET'){



    $treatment_id = isset($_GET["treatment_id"]) ? intval($_GET["treatment_id"]) : 0;

    if ($treatment_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    // retreive specific treatment and return JSON response
    retrieveTreatment( $conn, $treatment_id);

}

?>
