<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/UserService/userModel.php';

class UserController
{
    private $requestMethod;

    private $id;

    private $userService;

    public function __construct($requestMethod, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->id = $id;

        $this->userService = new UserService();
    }

    public function processRequest()
    {
        if ($this->validateRequestMethod()) {
            switch ($this->requestMethod) {
                case 'GET':
                    $response = $this->handleGetRequest();
                    break;
                case 'PUT':
                    $response = $this->handlePutRequest();
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
        if ($this->id) {
            return $this->getPersonalData($this->id);
        } else {
            return $this->notFoundResponse();
        }
    }

    private function handlePutRequest()
    {
        if (!$this->id) {
            return $this->unprocessableEntityResponse();
        }
        return $this->editPersonalData($this->id);
    }

    function getUser($id)
    {
        $result = $this->userService->getUser($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    function getPersonalData($id)
    {
        $result = $this->userService->getPersonalData($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    function editPersonalData($id)
    {
        $result = $this->getUser($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $input = $this->getRequestBody();
        $this->userService->editPersonalData($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'Personal Data Updated']);
        return $response;
    }

    private function getRequestBody()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    private function validateRequestMethod()
    {
        return in_array($this->requestMethod, ['GET', 'POST', 'PUT']);
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