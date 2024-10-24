<?php
// session_start();
// require '../../includes/auth.php';
// authorize(['admin']);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
require '../../includes/dbconn.php'; 

function registerPatient($data,$conn) {
   
      

    
    // Prepare the statement
    $query = "INSERT INTO patients (first_name, last_name, date_of_birth, gender, contact_number, email, address,emergency_contact_name,  emergency_contact_number   ) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";



    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        return json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'sssssssss', 
        $data->first_name, 
        $data->last_name, 
        $data->date_of_birth, 
        $data->gender, 
        $data->contact_number, 
        $data->email, 
        $data->address, 
        $data->emergency_contact_name, 
         $data->emergency_contact_number
        

       
    );

    

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return json_encode(['message' => 'Patient registered successfully']);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        return json_encode(['message' => 'Unable to register patient: ' . mysqli_error($conn)]);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive JSON data and decode it
    $data = json_decode(file_get_contents("php://input"));

    // Register doctor and return JSON response
    echo registerPatient($data,$conn);
}



?>