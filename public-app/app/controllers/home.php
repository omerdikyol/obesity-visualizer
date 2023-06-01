<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/models/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/home.php';