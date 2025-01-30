<?php
//Permite acceso a cualqueir dominio
header("Access-Control-Allow-Origin: *")
//Methods Permitted
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

//Cookies 
header("Access-Control-Allow-Credentials: true"); 

require_once '../core/Router.php';

//Obtener la URL de la petición

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUESTS_METHOD'];

//Crear instancias y procesar la solicitud
$router = new Router();
$router->handleRequest($requestUri, $requestMethod);
?>