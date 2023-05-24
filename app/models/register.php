<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/userService/userService.php';

register();

# Redirect to login page
header("Location: /obesity-visualizer/app/controllers/login.php");