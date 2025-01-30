<?php
// Include the Database model
require_once '../models/Database.php';

class User {
    // Method to find a user by email
    public static function findByEmail($email) {
        // Create a new instance of the Database class
        $db = new Database();
        
        // Get the database connection
        $conn = $db->getConnection();
        
        // Prepare the SQL statement to select the user by email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        
        // Bind the email parameter to the query
        $stmt->bindParam(":email", $email);
        
        // Execute the query
        $stmt->execute();
        
        // Return the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
