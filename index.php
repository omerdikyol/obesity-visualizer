<?php

header("Location: /obesity-visualizer/public-app/app/controllers/home.php");

/*
// index.php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/routes/AdminController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/routes/CountryController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/routes/ChartController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/routes/UserController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/routes/LoginController.php';


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// our endpoints start with /admin, /country or /user
if ($uri[2] !== 'admin' && $uri[2] !== 'country' && $uri[2] !== 'user' && $uri[2] !== 'chart' && $uri[2] !== 'auth') {
header("HTTP/1.1 404 Not Found");
exit();
}

// the id is optional and must be a number:
$id = null;
$idIndex = 3; // the index where the id is in the uri (usually 3)

$type = null;

// Make changes to the header depending on the endpoint
switch ($uri[2]) {
case 'admin':
$type = $uri[3];
$idIndex = 4; // increment because of the type (countries or users)
break;
case 'country':
if ($uri[3] === 'names' || $uri[3] === 'codes') {
$idIndex = 4; // no id needed
$type = $uri[3];
}
break;
case 'user':
break;
case 'chart':
if (isset($uri[3]) && isset($uri[4])) { // both year and bmi
$bmi = $uri[3];
$year = $uri[4];
} else if (isset($uri[3])) { // only bmi
$bmi = $uri[3];
$year = null;
} else { // no bmi or year
$bmi = null;
$year = null;
}
break;
case 'auth':
if (isset($uri[3])) {
$type = $uri[3];
$idIndex = 4; // no id needed
}
break;
default:
break;
}

if (isset($uri[$idIndex])) {
$id = (int) $uri[$idIndex];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and parameters
if ($uri[2] === 'admin') {
$controller = new AdminController($requestMethod, $type, $id);
} else if ($uri[2] === 'country') {
$controller = new CountryController($requestMethod, $id, $type);
} else if ($uri[2] === 'user') {
$controller = new UserController($requestMethod, $id);
} else if ($uri[2] === 'chart') {
$controller = new ChartController($requestMethod, $year, $bmi);
} else if ($uri[2] === 'auth') {
$controller = new LoginController($requestMethod, $type);
}

$controller->processRequest();
*/