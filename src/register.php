<?php
// CORS headers
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once 'config.php';
require_once 'jwt.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepared statement for checking if user exists
    $sql = "SELECT * FROM users WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(["message" => "User already exists"]);
            exit;
        }
    } else {
        echo json_encode(["message" => "Error preparing statement"]);
        exit;
    }

    // Prepared statement for inserting the new user
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            echo json_encode(["message" => "User registered successfully"]);
        } else {
            echo json_encode(["message" => "Error: " . $stmt->error]);
        }
    } else {
        echo json_encode(["message" => "Error preparing statement"]);
    }
} else {
    echo json_encode(["message" => "Missing data"]);
    exit;
}
?>
