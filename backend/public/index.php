<?php
//Permite acceso a cualqueir dominio
header("Accesss-Control-Allow-Origin: *")
//Methods Permitted
header("Accesss-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Accesss-Control-Allow-Headers Content-Type, Authorization");

require_once '../core/Router.php';

//Obtener la URL de la petición

$requestUri = $_SERVER['Request_URI'];
$requestMethod = $SERVER['REQUESTS_METHOD'];

//Crear instancias y procesar la solicitud
$router = new Router();
$router->handleRequest($requestUri, $requestMethod);
?>