<?php
require_once '../controllers/UserController.php';

if ($_SERVER['REQUEST_METHOT'] === && $_GET['action'] === 'login') {
    $controller = new UserController();
    $controller->login();
}
?>