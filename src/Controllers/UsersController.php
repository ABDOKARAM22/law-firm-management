<?php

namespace LawFirmManagement\Controllers;

use InvalidArgumentException;
use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Services\UserService;


class UsersController
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function index(): void
    {
        $users = $this->userService->getAll();

        require __DIR__ . '/../Views/users/index.php';
    }

    public function create(): void
    {
        require __DIR__ . '/../Views/users/create.php';
    }

    public function store(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? '';
        $status = $_POST['status'] ?? '';

        if (is_string($name)) {
            $name = trim($name);
        }

        if (is_string($email)) {
            $email = trim($email);
        }

        try {
        $this->userService->create(
            $name,
            $email,
            $password,
            $role,
            $status
        );

            Flash::set(
                'success',
                'تم إضافة المستخدم بنجاح.'
            );

            header('Location: ?route=users');
            exit;

        }catch (ValidationException $exception) {

            Flash::set(
                'errors',
                $exception->errors()
            );

            Flash::set(
                'old',
                [
                    'name' => $_POST['name'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'role' => $_POST['role'] ?? '',
                    'status' => $_POST['status'] ?? '',
                ]
            );

            header('Location: ?route=users/create');
            exit;
        }
    }
}