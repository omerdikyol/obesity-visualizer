<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/LoginService/LoginController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// our endpoints start with /auth
if ($uri[2] !== 'auth') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

$type = isset($_GET['type']) ? $_GET['type'] : null;

// pass the request method and parameters
$controller = new LoginController($requestMethod, $type);
$controller->processRequest();