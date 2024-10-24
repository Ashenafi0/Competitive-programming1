<?php
// session_start();
// require '../../includes/auth.php';
// authorize(['admin',"doctor"]);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

header('Content-Type: application/json');
require '../../includes/dbconn.php'; 

function addMedications($data, $conn, $visit_id) {
    // Prepare the statement
    $query = "INSERT INTO medications (visit_id, medication_name, dosage,instructions) 
              VALUES (?, ?, ?,?)";

 



    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'ssss', 
        $visit_id,
        $data->medication_name,
        $data->dosage,
        $data->instructions
    );

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        http_response_code(200);
        echo json_encode(['message' => 'medications registered successfully']);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        echo json_encode(['message' => 'Unable to register medications: ' . mysqli_error($conn)]);
    }
}

function retrieveAllMedicationForVisit( $conn, $visit_id){


// Prepare the statement
    $query = "SELECT   *  FROM medications WHERE visit_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind the visit_id parameter
    mysqli_stmt_bind_param($stmt, 'i', $visit_id);

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
        echo json_encode(['message' => 'Unable to retrieve medications: ' . mysqli_error($conn)]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive JSON data and decode it
    $data = json_decode(file_get_contents("php://input"));
    $visit_id = isset($_GET["visit_id"]) ? intval($_GET["visit_id"]) : 0;

    if ($visit_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    // Register patient and return JSON response
    addMedications($data, $conn, $visit_id);
}
elseif($_SERVER['REQUEST_METHOD'] === 'GET'){



    $visit_id = isset($_GET["visit_id"]) ? intval($_GET["visit_id"]) : 0;

    if ($visit_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    // retreive all medications for a visit and return JSON response
    retrieveAllMedicationForVisit( $conn, $visit_id);

}

?>
