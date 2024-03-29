<?php

if (!isset($mysqli))
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/db/database.php';

class ChartService
{
    # Returns data for a specific bmi (used in line chart)
    function getFromBmi($bmi)
    {
        switch ($bmi) {
            case "Overweight":
                $bmi = "BMI_GE25";
                break;
            case "Pre-obese":
                $bmi = "BMI25-29";
                break;
            case "Obese":
                $bmi = "BMI_GE30";
                break;
        }
        global $mysqli;
        $sql = sprintf(
            "SELECT * FROM public_data WHERE bmi ='%s'",
            $mysqli->real_escape_string($bmi),
        );
        $result = $mysqli->query($sql);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $row["value"] = floatval($row["value"]);
            $data[] = $row;
        }
        return json_encode($data);
    }

    # Returns data for a specific year and bmi (used in pie chart)
    function getFromYearAndBmi($year, $bmi)
    {
        switch ($bmi) {
            case "Overweight":
                $bmi = "BMI_GE25";
                break;
            case "Pre-obese":
                $bmi = "BMI25-29";
                break;
            case "Obese":
                $bmi = "BMI_GE30";
                break;
        }
        global $mysqli;
        $sql = sprintf(
            "SELECT * FROM public_data WHERE year = '%s' AND bmi ='%s'",
            $mysqli->real_escape_string($year),
            $mysqli->real_escape_string($bmi)
        );
        $result = $mysqli->query($sql);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $temp = array();
            $temp["country"] = $row['geo'];
            $temp["value"] = floatval($row['value']);
            $data[] = $temp;
        }
        return json_encode($data);
    }

    # Returns all data from db and groups it by bmi (used in table)
    function getAllData()
    {
        global $mysqli;
        $sql = "SELECT * FROM public_data";
        $result = $mysqli->query($sql);
        $data = array();
        $data["Overweight"] = array();
        $data["Pre-obese"] = array();
        $data["Obese"] = array();
        while ($row = $result->fetch_assoc()) {
            $bmi = $row['bmi'];
            switch ($row["bmi"]) {
                case "BMI_GE25":
                    $bmi = "Overweight";
                    break;
                case "BMI25-29":
                    $bmi = "Pre-obese";
                    break;
                case "BMI_GE30":
                    $bmi = "Obese";
                    break;
            }
            $data[$bmi][$row['geo']][$row['year']] = floatval($row['value']);
        }
        return json_encode($data);
    }
}
