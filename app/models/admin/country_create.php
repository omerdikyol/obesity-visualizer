<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService/adminService.php';

createCountry();

header("Location: /obesity-visualizer/app/controllers/admin/countries.php");
exit(0);