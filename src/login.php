<?php
require_once 'config.php';
require_once 'jwt.php';
header("Access-Control-Allow-Origin: http://localhost:3000"); // Allow React app on localhost:3000
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow certain HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow custom headers
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Handle OPTIONS requests (preflight requests from browsers)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo json_encode(["message" => "User not found"]);
        exit;
    }

    $user = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        $payload = [
            "id" => $user['id'],
            "username" => $user['username'],
            "iat" => time(),
            "exp" => time() + 3600 // 1 hour expiration
        ];

        $jwt = JWTHandler::encode($payload);
        echo json_encode(["message" => "Login successful", "token" => $jwt]);
    } else {
        echo json_encode(["message" => "Invalid credentials"]);
    }
}
?>
