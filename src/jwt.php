<?php
require_once 'vendor/autoload.php'; // Include the Composer autoloader
use \Firebase\JWT\JWT;
header("Access-Control-Allow-Origin: http://localhost:3000"); // Allow React app on localhost:3000
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow certain HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow custom headers

// Handle OPTIONS requests (preflight requests from browsers)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}
class JWTHandler {
    private static $secretKey = 'YOUR_SECRET_KEY'; // Set your secret key here

    public static function encode($data) {
        return JWT::encode($data, self::$secretKey);
    }

    public static function decode($jwt) {
        try {
            return JWT::decode($jwt, self::$secretKey, array('HS256'));
        } catch (Exception $e) {
            return null; // Invalid token
        }
    }
}
?>
