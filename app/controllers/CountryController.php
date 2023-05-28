<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/countryService.php';

class CountryController
{
    private $requestMethod;

    private $type;
    private $id;
    private $countryService;

    public function __construct($requestMethod, $id, $type)
    {
        $this->requestMethod = $requestMethod;
        $this->id = $id;
        $this->type = $type;

        $this->countryService = new CountryService();
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
        if ($this->id && !$this->type) {
            $response = $this->getCountry($this->id);
        } else if ($this->type) {
            switch ($this->type) {
                case 'codes':
                    $response = $this->getCountryCodes();
                    break;
                case 'names':
                    $response = $this->getCountryNames();
                    break;
                default:
                    $response = $this->unprocessableEntityResponse();
                    break;
            }
        } else if (!$this->id && !$this->type) {
            $response = $this->getCountries();
        } else {
            $response = $this->unprocessableEntityResponse();
        }
        return $response;
    }

    private function getCountries()
    {
        $result = $this->countryService->getCountries();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getCountry($id)
    {
        $result = $this->countryService->getCountry($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getCountryCodes()
    {
        $result = $this->countryService->getCountryCodes();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getCountryNames()
    {
        $result = $this->countryService->getCountryNames();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }


    private function validateRequestMethod()
    {
        return (strcmp($this->requestMethod, 'GET') == 0);
    }

    private function getRequestBody()
    {
        return json_decode(file_get_contents('php://input'), true);
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