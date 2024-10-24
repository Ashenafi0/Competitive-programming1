<?php


// session_start();
// require '../includes/auth.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

header('Content-Type: application/json');
require '../includes/dbconn.php'; 

function registerDoctor($data,$conn) {
   
      // Prepare query to check if username exists
    $checkQuery = "SELECT username FROM doctors WHERE username = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, 's', $data->username);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    // Check if username already exists
    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        mysqli_stmt_close($checkStmt);
        mysqli_close($conn);
        http_response_code(400);
        return json_encode(['message' => 'Username already exists']);
    }

    mysqli_stmt_close($checkStmt);

    
    // Prepare the statement
    $query = "INSERT INTO doctors (first_name, last_name, date_of_birth, gender, contact_number, email, address, license_number, specialization, years_of_experience, username, password_hash,role) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";



    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        return json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'sssssssssssss', 
        $data->first_name, 
        $data->last_name, 
        $data->date_of_birth, 
        $data->gender, 
        $data->contact_number, 
        $data->email, 
        $data->address, 
        $data->license_number, 
        $data->specialization, 
        $data->years_of_experience, 
        $data->username, 
        password_hash($data->password, PASSWORD_BCRYPT),
        $data->role
    ); 

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return json_encode(['message' => 'Doctor registered successfully']);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        return json_encode(['message' => 'Unable to register doctor: ' . mysqli_error($conn)]);
    }
}


function updateDoctorInfo($data, $conn, $doctor_id) {
    // Prepare the update statement
    $query = "UPDATE doctors
SET 
    first_name = ?,
    last_name = ?,
    date_of_birth = ?,
    gender = ?,
    contact_number = ?,
    email = ?,
    address = ?,
   license_number =?,
    specialization =?,
   years_of_experience =?,
    username =?,
    password_hash =?
WHERE 
    id = ?;

";


    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, 'ssssssssssssi', 
        $data->first_name, 
        $data->last_name, 
        $data->date_of_birth,
        $data->gender,
        $data->contact_number,
        $data->email,
        $data->address,
        $data->license_number,
        $data->specialization,
        $data->years_of_experience,
        $data->username,
         password_hash($data->password_hash, PASSWORD_BCRYPT),
        $doctor_id
    );

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        http_response_code(200);
        echo json_encode(['message' => 'Doctor information  updated successfully']);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        echo json_encode(['message' => 'Unable to update doctor information: ' . mysqli_error($conn)]);
    }
}

function retrieveAllDoctorInfo( $conn){
    $sql = "SELECT 
    id,
    first_name,
    last_name,
    date_of_birth,
    gender,
    contact_number,
    email,
    address,
    license_number,
    specialization,
    years_of_experience,
    username,
    role
FROM 
    doctors";

// Initialize the prepared statement
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch all rows as an associative array
    $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Return the data as JSON
    echo json_encode($doctors);
} else {
    echo json_encode(["error" => "Failed to prepare the SQL statement."]);
}

// Close the connection
mysqli_close($conn);
}


function retrieveDoctorInfo( $conn, $doctor_id) 
{
// Prepare the statement
    $query = "SELECT
    id, 
    first_name,
    last_name,
    date_of_birth,
    gender,
    contact_number,
    email,
    address,
    license_number,
    specialization,
    years_of_experience,
    username,
    role
FROM 
    doctors
WHERE 
    id = ?;
";


    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
        return;
    }

    // Bind the visit_id parameter
    mysqli_stmt_bind_param($stmt, 'i', $doctor_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $doctor = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        if (empty($doctor)) {
    http_response_code(404);
    echo json_encode(['message' => 'User does not exist']);
} else {
    // Return treatments as JSON
   http_response_code(200);
        echo json_encode($doctor);
}
        
       
        
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        echo json_encode(['message' => 'Unable to retrieve doctor info: ' . mysqli_error($conn)]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive JSON data and decode it
    $data = json_decode(file_get_contents("php://input"));

    // Register doctor and return JSON response
    echo registerDoctor($data,$conn);
}elseif($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Assuming you receive JSON data and decode it
    $data = json_decode(file_get_contents("php://input"));
    $doctor_id = isset($_GET["doctor_id"]) ? intval($_GET["doctor_id"]) : 0;

    if ($doctor_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    // Register patient and return JSON response
    updateDoctorInfo($data, $conn, $doctor_id);
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET["doctor_id"]) ){
     $doctor_id = isset($_GET["doctor_id"]) ? intval($_GET["doctor_id"]) : 0;

    if ($doctor_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' =>$doctor_id ]);
        return;
    }

    retrieveDoctorInfo( $conn, $doctor_id);

}elseif($_SERVER['REQUEST_METHOD'] === 'GET'){

    retrieveAllDoctorInfo($conn);
}


?>