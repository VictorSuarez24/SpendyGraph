<?php
class Router {
    public function handleRequest($uri, $method) {
        require_once '../controllers/UserController.php';
        require_once '../controllers/TransactionController.php';

        $routes = [
            'GET' => [
                '/users' => ['UserController', 'getAllUsers'],
                '/transactions' => ['TransactionController', 'getAllTransactions']
            ],
            'POST' => [
                '/login' => ['UserController', 'login'],
                '/transactions' => ['TransactionController', 'createTransaction']
            ]
        ];

        $path = parse_url($uri, PHP_URL_PATH);
        if (isset($routes[$method][$path])) {
            [$controller, $action] = $routes[$method][$path];
            $instance = new $controller();
            $instance->$action();
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Ruta no encontrada"]);
        }
    }
}
?>
