<?php
require_once '../models/User.php';
require_once '../core/Response.php';

class UserController {
    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['email']) || !isset($data['password'])) {
            Response::json(["error" => "Faltan datos"], 400);
            return;
        }

        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $password = $data['password'];

        if (!$email) {
            Response::json(["error" => "Correo electrónico no válido"], 400);
            return;
        }

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            Response::json(["error" => "Credenciales incorrectas"], 401);
            return;
        }

        $_SESSION['user_id'] = $user['id'];

        Response::json(["message" => "Login exitoso", "user" => $user]);
    }
}
?>
