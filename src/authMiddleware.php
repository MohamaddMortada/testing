<?php


require_once 'jwt.php';
header("Access-Control-Allow-Origin: http://localhost:3000"); // Allow React app on localhost:3000
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow certain HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow custom headers

// Handle OPTIONS requests (preflight requests from browsers)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}
function authenticate() {
    $headers = getallheaders();

    if (isset($headers['Authorization'])) {
        $jwt = str_replace("Bearer ", "", $headers['Authorization']);
        $decoded = JWTHandler::decode($jwt);

        if ($decoded) {
            return $decoded;
        }
    }

    return null;
}
?>
