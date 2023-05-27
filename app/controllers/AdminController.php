<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService.php';

class AdminController
{
    private $requestMethod;
    private $type;
    private $id;
    private $adminService;

    public function __construct($requestMethod, $type, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->type = $type;
        $this->id = $id;

        $this->adminService = new AdminService();
    }

    public function processRequest()
    {
        if ($this->validateRequestMethod()) {
            switch ($this->requestMethod) {
                case 'GET':
                    $response = $this->handleGetRequest();
                    break;
                case 'POST':
                    $response = $this->handlePostRequest();
                    break;
                case 'PUT':
                    $response = $this->handlePutRequest();
                    break;
                case 'DELETE':
                    $response = $this->handleDeleteRequest();
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
        if ($this->type === 'countries') {
            if ($this->id) {
                return $this->getCountry($this->id);
            } else {
                return $this->getCountries();
            }
        } else if ($this->type === 'users') {
            if ($this->id) {
                return $this->getUser($this->id);
            } else {
                return $this->getUsers();
            }
        } else {
            return $this->notFoundResponse();
        }
    }

    private function handlePostRequest()
    {
        if ($this->type === 'countries') {
            return $this->createCountry();
        } else if ($this->type === 'users') {
            return $this->createUser();
        } else {
            return $this->notFoundResponse();
        }
    }

    private function handlePutRequest()
    {
        if ($this->type === 'countries') {
            return $this->editCountry($this->id);
        } else if ($this->type === 'users') {
            return $this->editUser($this->id);
        } else {
            return $this->notFoundResponse();
        }
    }

    private function handleDeleteRequest()
    {
        if ($this->type === 'countries') {
            return $this->deleteCountry($this->id);
        } else if ($this->type === 'users') {
            return $this->deleteUser($this->id);
        } else {
            return $this->notFoundResponse();
        }
    }

    private function getCountries()
    {
        $result = $this->adminService->getCountriesAdmin();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getCountry($id)
    {
        $result = $this->adminService->getCountryAdmin($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createCountry()
    {
        $input = $this->getRequestBody();
        if (!$this->validateCountry($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->adminService->createCountry($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(['status' => 'success']);
        return $response;
    }

    private function editCountry($id)
    {
        $result = $this->getCountry($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $input = $this->getRequestBody();
        if (!$this->validateCountry($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->adminService->editCountry($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['status' => 'success']);
        return $response;
    }

    private function deleteCountry($id)
    {
        $result = $this->getCountry($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $this->adminService->deleteCountry($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['status' => 'success']);
        return $response;
    }

    private function getUsers()
    {
        $result = $this->adminService->getUsers();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getUser($id)
    {
        $result = $this->adminService->getUser($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createUser()
    {
        $input = $this->getRequestBody();
        if (!$this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->adminService->createUser($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(['status' => 'success']);
        return $response;
    }

    private function editUser($id)
    {
        $result = $this->getUser($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $input = $this->getRequestBody();
        if (!$this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->adminService->editUser($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['status' => 'success']);
        return $response;
    }

    private function deleteUser($id)
    {
        $result = $this->getUser($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $this->adminService->deleteUser($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['status' => 'success']);
        return $response;
    }

    private function validateRequestMethod()
    {
        return in_array($this->requestMethod, ['GET', 'POST', 'PUT', 'DELETE']);
    }

    private function validateCountry($input)
    {
        return isset($input['bmi']) && isset($input['geo']) && isset($input['year']) && isset($input['value']);
    }

    private function validateUser($input)
    {
        return isset($input['name']) && isset($input['email']);
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