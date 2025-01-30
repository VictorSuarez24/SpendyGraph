<?php
require_once '../models/User.php';
require_once '../core/Response.php';
require_once '../config/config.php'; // Database configuration

class UserController {

    private $db;

    public function __construct() {
        // Establish database connection
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->db->connect_error) {
            die("Database connection error: " . $this->db->connect_error);
        }
    }

    public function login() {
        // Attempt to decode the JSON
        $data = json_decode(file_get_contents("php://input"));
        
        // Check if there was an error decoding the JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["message" => "Incorrect JSON format"]);
            return;
        }

        // Add this line to debug the content of $data
        error_log(print_r($data, true));  // This will log the content to the server logs

        // Check if $data is null or doesn't contain the expected properties
        if (is_null($data) || !isset($data->email) || !isset($data->password)) {
            echo json_encode(["message" => "Incomplete data or incorrect format"]);
            return;
        }

        // Query to check if the user exists
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $data->email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password (in production, you should use bcrypt or something similar for comparison)
            if ($user['password'] == $data->password) {
                echo json_encode(["message" => "Login successful"]);
            } else {
                echo json_encode(["message" => "Incorrect credentials"]);
            }
        } else {
            echo json_encode(["message" => "User not found"]);
        }

        $stmt->close();
    }

    // Add a new user
    public function addUser() {
        $data = json_decode(file_get_contents("php://input"));
        
        // Validate if the email and password are correct
        if (isset($data->email) && isset($data->password)) {
            // Prevent SQL injection and sanitize the data
            $email = $this->db->real_escape_string($data->email);
            $password = password_hash($data->password, PASSWORD_DEFAULT); // Hash the password

            // Check if the user already exists
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo json_encode(["message" => "User already exists"]);
            } else {
                // Insert new user
                $insertQuery = "INSERT INTO users (email, password) VALUES (?, ?)";
                $stmt = $this->db->prepare($insertQuery);
                $stmt->bind_param("ss", $email, $password);

                if ($stmt->execute()) {
                    echo json_encode(["message" => "User successfully registered"]);
                } else {
                    echo json_encode(["message" => "Error registering the user"]);
                }
            }

            $stmt->close();
        } else {
            echo json_encode(["message" => "Incomplete data"]);
        }
    }
}
?>
