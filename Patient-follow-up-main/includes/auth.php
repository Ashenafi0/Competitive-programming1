<?php
session_start();

function isAuthenticated() {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        exit();
    }
}

function authorize($roles) {
    isAuthenticated();
    if (!in_array($_SESSION['role'], $roles)) {
        http_response_code(403);
        echo json_encode(['message' => 'Forbidden']);
        exit();
    }
}

?>
