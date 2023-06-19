<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/LoginService/loginModel.php';

class LoginController
{
    private $requestMethod;
    private $type;
    private $loginService;

    public function __construct($requestMethod, $type)
    {
        $this->requestMethod = $requestMethod;
        $this->type = $type;

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

        $result = $this->loginService->register($input);

        if ($result < 0) {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';

            switch ($result) {
                case -1:
                    $response['body'] = json_encode(["success" => false, "error" => "Email is required"]);
                    break;
                case -2:
                    $response['body'] = json_encode(["success" => false, "error" => "Invalid email"]);
                    break;
                case -3:
                    $response['body'] = json_encode(["success" => false, "error" => "Password must be at least 8 characters long"]);
                    break;
                case -4:
                    $response['body'] = json_encode(["success" => false, "error" => "Password must contain at least one number and one letter"]);
                    break;
                case -5:
                    $response['body'] = json_encode(["success" => false, "error" => "Passwords do not match"]);
                    break;
                case -6:
                    $response['body'] = json_encode(["success" => false, "error" => "Date of birth is required"]);
                    break;
                case -7:
                    $response['body'] = json_encode(["success" => false, "error" => "Invalid date format"]);
                    break;
                case -8:
                    $response['body'] = json_encode(["success" => false, "error" => "Date must be between 1900 and 2020"]);
                    break;
                case -9:
                    $response['body'] = json_encode(["success" => false, "error" => "Email already exists"]);
                    break;
                case -10:
                    $response['body'] = json_encode(["success" => false, "error" => "SQL Error"]);
                    break;
                default:
                    $response['body'] = json_encode(["success" => false, "error" => "Unknown error"]);
                    break;
            }
            return $response;
        }

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