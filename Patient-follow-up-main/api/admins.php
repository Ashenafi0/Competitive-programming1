<?php
// session_start();
// require '../includes/auth.php';
// authorize(['admin']);

require '../includes/dbconn.php'; 

function registerAdmins($data,$conn) {
   
      // Prepare query to check if username exists
    $checkQuery = "SELECT username FROM admins WHERE username = ?";
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
    $query = "INSERT INTO admins (first_name, last_name, date_of_birth, gender, contact_number, email, address,  username, password_hash,role) 
              VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";


    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        http_response_code(500);
        return json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'ssssssssss', 
        $data->first_name, 
        $data->last_name, 
        $data->date_of_birth, 
        $data->gender, 
        $data->contact_number, 
        $data->email, 
        $data->address, 
        $data->username, 
        password_hash($data->password, PASSWORD_BCRYPT),
      $data->role
    );

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return json_encode(['message' => 'Admin registered successfully']);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        return json_encode(['message' => 'Unable to register admin: ' . mysqli_error($conn)]);
    }
}

function updateAdminInfo($data, $conn, $admin_id) {
    // Prepare the update statement
    $query = "UPDATE admins
SET 
    first_name = ?,
    last_name = ?,
    date_of_birth = ?,
    gender = ?,
    contact_number = ?,
    email = ?,
    address = ?,
    username = ?,
    password_hash = ?
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
    mysqli_stmt_bind_param($stmt, 'sssssssssi', 
        $data->first_name, 
        $data->last_name, 
        $data->date_of_birth,
        $data->gender,
        $data->contact_number,
        $data->email,
        $data->address,
        $data->username,
       
        password_hash($data->password_hash, PASSWORD_BCRYPT),
        $admin_id
    );

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        http_response_code(200);
        echo json_encode(['message' => 'Admin information  updated successfully']);
    } else {
        mysqli_stmt_close($stmt);
        http_response_code(400);
        echo json_encode(['message' => 'Unable to update admin information: ' . mysqli_error($conn)]);
    }
}

function retrieveAdminInfo( $conn, $admin_id) 
{
// Prepare the statement
    $query = "SELECT 
    first_name,
    last_name,
    date_of_birth,
    gender,
    contact_number,
    email,
    address,
    username
FROM 
    admins
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
    mysqli_stmt_bind_param($stmt, 'i', $admin_id);

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
        echo json_encode(['message' => 'Unable to retrieve admin info: ' . mysqli_error($conn)]);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive JSON data and decode it
    $data = json_decode(file_get_contents("php://input"));

    // Register admins and return JSON response
    echo registerAdmins($data,$conn);
}
elseif($_SERVER['REQUEST_METHOD'] === 'GET'){



    $admin_id = isset($_GET["admin_id"]) ? intval($_GET["admin_id"]) : 0;

    if ($admin_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    // retreive specific treatment and return JSON response
    retrieveAdminInfo( $conn, $admin_id);

} elseif($_SERVER['REQUEST_METHOD'] === 'PUT'){
    $data = json_decode(file_get_contents("php://input"));
    $admin_id = isset($_GET["admin_id"]) ? intval($_GET["admin_id"]) : 0;

    if ($admin_id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
        return;
    }

    // Register patient and return JSON response
    updateAdminInfo($data, $conn, $admin_id);

}




?>