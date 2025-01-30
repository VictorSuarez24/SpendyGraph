<?php
require_once '../models/Database-php';

class User {
    public static function findByEmail($email) {
        $pdo =Database::connect();
        $stmt = $pdo->prepare("SELECT + FROM users WHERE email = ?";)
        $stmt -> execute([$email]);
        return $stmt ->Fetch(PDO::FETCH_ASSOC);
    }
}
?>