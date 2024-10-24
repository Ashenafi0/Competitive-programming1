<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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

// Define routes and their corresponding files
$routes = [
    "checkauth"  => '../api/checkauth.php',
    'doctors' => '../api/doctors.php',
    'admins' => '../api/admins.php',
    'login' => '../api/login.php',
    'logout' => '../api/logout.php',
    'visit/visits' => '../api/visit/visits.php',
    'visit/treatments' => '../api/visit/treatments.php',
    'treatments' => '../api/treatments.php',
    'visit/medications' => '../api/visit/medications.php',
    'medications' => '../api/medications.php',
    'visit/follow-ups' => '../api/visit/follow-ups.php',
    'follow_ups' => '../api/follow_ups.php',
    'visit/providers' => '../api/visit/providers.php',

    'files/delete_file' => '../api/files/delete_file.php',
    'files/download_file' => '../api/files/download_file.php',
     'files/get_files' => '../api/files/get_files.php',
      'files/uploads_file' => '../api/files/uploads_file.php',

      'diagnoses/create_diagnosis' => '../api/diagnoses/create_diagnosis.php',
      'diagnoses/get_diagnoses' => '../api/diagnoses/get_diagnoses.php',
      'diagnoses/get_diagnosis' => '../api/diagnoses/get_diagnosis.php',
      'diagnoses/update_diagnosis' => '../api/diagnoses/update_diagnosis.php',

         'patients/patient' => '../api/patients/patient.php',
        'patients/get_patient' => '../api/patients/get_patient.php',
        'patients/get_patients' => '../api/patients/get_patients.php',
        'patients/update_patient' => '../api/patients/update_patient.php',

    'visit/get_visit ' => '../api/visit/get_visit.php',
    'visit/get_visits' => '../api/visit/get_visits.php',
    'visit/update_visit' => '../api/visit/update_visit.php',
"checkSession" => "../api/checkSession.php"
];

// Get the requested URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Remove the project root from the URI if present
$baseUri = 'finalProject/api/';

if (strpos($uri, $baseUri) === 0) {
    $uri = substr($uri, strlen($baseUri));
}

// Extract the base path (first segment)
$base = explode('/', $uri)[0];

if (array_key_exists($base, $routes)) {
    // Include the appropriate file
    require $routes[$base];
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint not found']);
}
