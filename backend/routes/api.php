<?php
require_once '../controllers/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $controller = new UserController();
    $controller->login();
}
?>