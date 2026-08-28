<?php

namespace LawFirmManagement\Controllers;

use LawFirmManagement\Core\Auth;
use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;

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

            Flash::set(
                'error',
                'طلب غير صالح، يرجى المحاولة مرة أخرى.'
            );

            header('Location: ?route=login');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($this->auth->login($email, $password)) {
            Flash::set(
                'success',
                'تم تسجيل الدخول بنجاح.'
            );

            header('Location: ?route=dashboard');
            exit;
        }

        Flash::set(
            'error',
            'البريد الإلكتروني أو كلمة المرور غير صحيحة.'
        );

        header('Location: ?route=login');
        exit;
    }


    public function logout(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        $this->auth->logout();

        header('Location: ?route=login');
        exit;
    }
}