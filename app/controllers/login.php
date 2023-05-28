<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/userService.php';

if (session_status() == PHP_SESSION_NONE)
    session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/login.php';