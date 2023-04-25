<?php

function getUser()
{
    session_start();

    // Check if session user_id exists
    if (isset($_SESSION['user_id'])) {

        $mysqli = require_once('../db/database.php');

        $sql = sprintf("SELECT * FROM user WHERE id = '%s'", $mysqli->real_escape_string($_SESSION['user_id']));

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();


        if ($user) {
            $name = $user['name'];
            $email = $user['email'];
            $country = $user['country'];
            $date_of_birth = $user['date_of_birth'];
            $height = ($user['height'] == 0) ? "-" : $user['height'];
            $weight = ($user['weight'] == 0) ? "-" : $user['weight'];
            $bmi = "-";
        }

        # if height and weight are set, calculate BMI
        if ($height != "-" && $weight != "-") {
            $bmi = $weight / (($height / 100) * ($height / 100));
            $bmi = round($bmi, 2);

            # if BMI is less than 18.5, it is underweight
            if ($bmi < 18.5) {
                $bmi = $bmi . " (Underweight)";
            }
            # if BMI is between 18.5 and 24.9, it is normal
            else if ($bmi >= 18.5 && $bmi <= 24.9) {
                $bmi = $bmi . " (Normal)";
            }
            # if BMI is between 25 and 29.9, it is overweight
            else if ($bmi >= 25 && $bmi <= 29.9) {
                $bmi = $bmi . " (Overweight)";
            }
            # if BMI is greater than 30, it is obese
            else if ($bmi > 30) {
                $bmi = $bmi . " (Obese)";
            }

            # update user's BMI in database
            $sql = sprintf("UPDATE user SET bmi = '%s' WHERE id = '%s'", $mysqli->real_escape_string($bmi), $mysqli->real_escape_string($_SESSION['user_id']));
            $mysqli->query($sql);
        }

        return $user;
    }
}