<?php

require_once __DIR__ . '/../vendor/autoload.php'; 
require_once __DIR__ . '/../app/Controller/Api/CarApiController.php';

use App\Controller\Api\CarApiController;

//route countroll
header('Access-Control-Allow-Origin: *');
// Get HTTP method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// echo $uri;

$path = str_replace('/car-dealership-fullstack/public', '', $uri); 
$controller = new CarApiController();

// ROUTING LOGIC
if ($path === '/api/cars' && $method === 'GET') {
    $controller->index();
} 
elseif ($path === '/api/cars' && $method === 'POST') {
    $controller->store();
}
elseif (preg_match('#^/api/cars/(\d+)$#', $path, $matches)) {
    $id = (int) $matches[1];

    if ($method === 'GET') {
        $controller->show($id);
    } 
    elseif ($method === 'PUT') {
        $controller->update($id);
    } 
    elseif ($method === 'DELETE') {
        $controller->delete($id);
    } 
    else {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
    }
} 
else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}
