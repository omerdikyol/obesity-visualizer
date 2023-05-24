<?php

deleteCountry($id);

$_SESSION["alert_success"] = "Country Data deleted successfully";

header("Location: /obesity-visualizer/app/controllers/admin/countries.php");