<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/loginService.php';

class LoginController
{
    private $requestMethod;
    private $type;
    private $loginService;

    public function __construct($requestMethod, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->type = $id;

        $this->loginService = new LoginService();
    }

    public function processRequest()
    {
        if ($this->validateRequestMethod()) {
            switch ($this->requestMethod) {
                case 'POST':
                    $response = $this->handlePostRequest();
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

    private function handlePostRequest()
    {
        if ($this->type === 'register') {
            return $this->register();
        } else if ($this->type === 'login') {
            return $this->login();
        } else {
            return $this->notFoundResponse();
        }
    }

    private function login()
    {
        $input = $this->getRequestBody();

        $user = $this->loginService->login($input);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(["success" => true, "user" => $user]);
        return $response;
    }

    private function register()
    {
        $input = $this->getRequestBody();
        if (!$this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->loginService->register($input);

        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(["success" => true]);
        return $response;
    }

    private function validateRequestMethod()
    {
        return in_array($this->requestMethod, ['POST']);
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