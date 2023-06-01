<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/ChartService/ChartController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// our endpoints start with /chart
if ($uri[2] !== 'chart') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

$bmi = isset($_GET['bmi']) ? $_GET['bmi'] : null;
$year = isset($_GET['year']) ? $_GET['year'] : null;

$controller = new ChartController($requestMethod, $year, $bmi);
$controller->processRequest();