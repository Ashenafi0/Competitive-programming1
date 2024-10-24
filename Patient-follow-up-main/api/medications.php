<?php
// session_start();
// require '../includes/auth.php';
// authorize(['admin',"doctor"]);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

header('Content-Type: application/json');
require '../includes/dbconn.php'; 

function updateMedication($data, $conn, $medication_id) {
    // Prepare the update statement
    $query = "UPDATE medications
SET medication_name = ?, dosage = ?, instructions = ?
WHERE medication_id = ?;
";




    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, 'sssi', 
        $data->medication_name, 
        $data->dosage, 
        $data ->instructions,
        $medication_id
    );

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        http_response_code(200);
        echo json_encode(['message' => 'Medication  updated successfully']);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        echo json_encode(['message' => 'Unable to update medication: ' . mysqli_error($conn)]);
    }
}


function retrieveMedication( $conn, $medication_id) 
{

// Prepare the statement
    $query = "SELECT medication_id,visit_id, medication_name , dosage , instructions FROM medications WHERE medication_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind the visit_id parameter
    mysqli_stmt_bind_param($stmt, 'i', $medication_id);

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
        echo json_encode(['message' => 'Unable to retrieve medication: ' . mysqli_error($conn)]);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Assuming you receive JSON data and decode it
    $data = json_decode(file_get_contents("php://input"));
    $medication_id = isset($_GET["medication_id"]) ? intval($_GET["medication_id"]) : 0;

    if ($medication_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    updateMedication($data, $conn, $medication_id);
}
elseif($_SERVER['REQUEST_METHOD'] === 'GET'){



    $medication_id = isset($_GET["medication_id"]) ? intval($_GET["medication_id"]) : 0;

    if ($medication_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    // retreive specific medication and return JSON response
    retrieveMedication( $conn, $medication_id);

}

?>
