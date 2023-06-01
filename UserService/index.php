<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/UserService/UserController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// our endpoints start with /user
if ($uri[2] !== 'user') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

$id = isset($_GET['id']) ? $_GET['id'] : null;

// pass the request method and parameters
$controller = new UserController($requestMethod, $id);
$controller->processRequest();