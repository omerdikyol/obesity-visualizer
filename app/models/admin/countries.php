<?php

$url = 'http://localhost/obesity-visualizer/admin/countries';

$c = curl_init();
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
$res = curl_exec($c);
curl_close($c);

$countries = json_decode($res, true);