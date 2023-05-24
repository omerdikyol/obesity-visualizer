<?php

$id = $mysqli->real_escape_string($_GET['id']);

deleteUser($id);

$_SESSION["alert_success"] = "User deleted successfully";

header("Location: /obesity-visualizer/app/controllers/admin/users.php");