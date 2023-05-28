<?php
# Returns all data from db

$url = 'http://localhost/obesity-visualizer/chart/';

// Create a new cURL resource
$c = curl_init();
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
$res = curl_exec($c);
curl_close($c);

$data = json_decode($res, true);
echo $data;