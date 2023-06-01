<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/bmi_calc.php';
?>
<script>
function calculateBMI(event) {
    event.preventDefault();
    let height = document.getElementById("height").value;
    let weight = document.getElementById("weight").value;
    let bmi = weight / ((height / 100) * (height / 100));
    let category = "";
    if (bmi < 18.5) {
        category = "Underweight";
    } else if (bmi >= 18.5 && bmi <= 24.9) {
        category = "Normal weight";
    } else if (bmi >= 25 && bmi <= 29.9) {
        category = "Overweight";
    } else if (bmi >= 30 && bmi <= 34.9) {
        category = "Obese Class I";
    } else if (bmi >= 35 && bmi <= 39.9) {
        category = "Obese Class II";
    } else {
        category = "Obese Class III";
    }
    document.getElementById("bmi").innerHTML = bmi.toFixed(2) + " (" + category + ")";
    document.getElementById("result").style.display = "block";
}
</script>