<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/ChartService/chartModel.php';

class ChartController
{
    private $requestMethod;
    private $bmi;
    private $year;
    private $chartService;

    public function __construct($requestMethod, $year, $bmi)
    {
        $this->requestMethod = $requestMethod;
        $this->year = $year;
        $this->bmi = $bmi;

        $this->chartService = new ChartService();
    }

    public function processRequest()
    {
        if ($this->validateRequestMethod()) {
            switch ($this->requestMethod) {
                case 'GET':
                    $response = $this->handleGetRequest();
                    break;
                default:
                    $response = $this->notFoundResponse();
                    break;
            }
        } else {
            $response = $this->notAllowedResponse();
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function handleGetRequest()
    {
        if ($this->year && $this->bmi) {
            $response = $this->getFromYearAndBmi($this->year, $this->bmi);
        } else if ($this->bmi) {
            $response = $this->getFromBmi($this->bmi);
        } else if (!$this->year && !$this->bmi) {
            $response = $this->getAllData();
        } else {
            $response = $this->unprocessableEntityResponse();
        }
        return $response;
    }

    private function getAllData()
    {
        $result = $this->chartService->getAllData();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getFromYearAndBmi($year, $bmi)
    {
        $result = $this->chartService->getFromYearAndBmi($year, $bmi);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getFromBmi($bmi)
    {
        $result = $this->chartService->getFromBmi($bmi);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function validateRequestMethod()
    {
        return (strcmp($this->requestMethod, 'GET') == 0);
    }
    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode(['error' => 'Invalid input']);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(['error' => 'Not Found']);
        return $response;
    }

    private function notAllowedResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 405 Method Not Allowed';
        $response['body'] = json_encode(['error' => 'Method Not Allowed']);
        return $response;
    }
}