<?php
// index.php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/controllers/AdminController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// our endpoints start with /admin, /country or /user
if ($uri[2] !== 'admin' && $uri[2] !== 'country' && $uri[2] !== 'user') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// the id is optional and must be a number:
$id = null;
$idIndex = 3; // the index where the id is in the uri
if ($uri[2] === 'admin')
    $idIndex = 4; // increment because of the type (countries or users)

if (isset($uri[$idIndex])) {
    $id = (int) $uri[$idIndex];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and user ID
if ($uri[2] === 'admin') {
    $type = $uri[3];
    $controller = new AdminController($requestMethod, $type, $id);
} else if ($uri[2] === 'country') {
    //$controller = new CountryController($requestMethod, $id);
} else if ($uri[2] === 'user') {
    //$controller = new UserController($requestMethod, $id);
}

$controller->processRequest();