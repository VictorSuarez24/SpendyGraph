<?php
// Allow all connections
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");  // Allowed methods
header("Access-Control-Allow-Headers: Content-Type");  // Allowed headers
header("Content-Type: application/json");

// If the request is a preflight (OPTIONS), respond correctly
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Import the user controller
require_once '../controllers/UserController.php';

// Instantiate the user controller
$controller = new UserController();

// Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Attempt to read the JSON body
    $data = json_decode(file_get_contents("php://input"));

    // Check if the necessary data is present
    if (isset($data->email) && isset($data->password)) {
        $controller->addUser();  // Register user
    } else {
        $controller->login();  // Login if email or password is missing
    }
}
?>
