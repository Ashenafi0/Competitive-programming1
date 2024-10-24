<?php
// session_start();
// require '../includes/auth.php';
// authorize(['admin',"doctor"]);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

header('Content-Type: application/json');
require '../includes/dbconn.php'; 

function updateFollow_ups($data, $conn, $follow_up_id) {
    // Prepare the update statement
    $query = "UPDATE follow_ups
SET  follow_up_date = ?, follow_up_instructions  = ?
WHERE follow_up_id = ?;
";




    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, 'ssi', 
        $data->follow_up_date, 
        $data->follow_up_instructions, 
        
        $follow_up_id
    );

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        http_response_code(200);
        echo json_encode(['message' => 'Follow_ups  updated successfully']);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        echo json_encode(['message' => 'Unable to update follow_ups: ' . mysqli_error($conn)]);
    }
}


function retrieveFollow_ups( $conn, $follow_up_id) 
{

// Prepare the statement
    $query = "SELECT follow_up_id,visit_id,follow_up_date , follow_up_instructions  FROM follow_ups WHERE follow_up_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind the visit_id parameter
    mysqli_stmt_bind_param($stmt, 'i', $follow_up_id);

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
        echo json_encode(['message' => 'Unable to retrieve follow_up: ' . mysqli_error($conn)]);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Assuming you receive JSON data and decode it
    $data = json_decode(file_get_contents("php://input"));
    $follow_up_id = isset($_GET["follow_up_id"]) ? intval($_GET["follow_up_id"]) : 0;

    if ($follow_up_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    updateFollow_ups($data, $conn, $follow_up_id);
}
elseif($_SERVER['REQUEST_METHOD'] === 'GET'){



    $follow_up_id = isset($_GET["follow_up_id"]) ? intval($_GET["follow_up_id"]) : 0;

    if ($follow_up_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    // retreive specific treatment and return JSON response
    retrieveFollow_ups( $conn, $follow_up_id);

}

?>
