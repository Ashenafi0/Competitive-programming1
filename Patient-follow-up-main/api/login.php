<?php

session_start();
include_once '../includes/dbconn.php';


header("Access-Control-Allow-Origin: *");

// Allow the following methods
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Allow the following headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// If this is a preflight request, respond with 200 OK
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Response for preflight request
    http_response_code(200);
    exit;
}



function login($username, $password, $conn) {
    // Prepare and bind
    $query = "SELECT id, username, password_hash, role FROM doctors WHERE username = ? UNION SELECT id, username, password_hash, role FROM admins WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        http_response_code(500);
        return json_encode(['message' => 'Database error: ' . mysqli_error($conn)]);
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Use role directly from the database
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return json_encode(['message' => 'Login successful','role'=> $user['role'],'id'=>$user['id']]);
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    http_response_code(401);
    return json_encode(['message' => 'Login failed']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents("php://input");
    $data = json_decode($input);

    if (json_last_error() === JSON_ERROR_NONE && isset($data->username) && isset($data->password)) {
        echo login($data->username, $data->password, $conn);
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input 1111']);
    }
}
?>
