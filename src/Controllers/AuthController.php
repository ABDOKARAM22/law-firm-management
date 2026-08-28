<?php

namespace LawFirmManagement\Controllers;

use LawFirmManagement\Core\Auth;
use LawFirmManagement\Core\Csrf;

class AuthController
{
    public function __construct(
        private Auth $auth
    ) {
    }

    public function showLogin(): void
    {
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function login(): void
    {

        if (!Csrf::verify($_POST['_token'] ?? null)) {
        http_response_code(419);
        echo 'Invalid CSRF token';
        return;
}
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($this->auth->login($email, $password)) {
            echo 'Login successful';
            return;
        }

        echo 'Invalid email or password';
    }

    public function logout(): void
{
    $this->auth->logout();

    header('Location: ?route=login');
    exit;
}
}