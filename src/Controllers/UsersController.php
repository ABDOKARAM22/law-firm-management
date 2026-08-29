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



        public function edit(): void
    {
        $id = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if ($id === false || $id === null) {
            http_response_code(400);
            echo 'Invalid user ID';
            return;
        }

        $user = $this->userService->find($id);

        if ($user === null) {
            http_response_code(404);
            echo 'User not found';
            return;
        }

        require __DIR__ . '/../Views/users/edit.php';
    }


        public function update(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        $id = filter_input(
            INPUT_POST,
            'id',
            FILTER_VALIDATE_INT
        );

        if ($id === false || $id === null) {
            http_response_code(400);
            echo 'Invalid user ID';
            return;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? '';
        $status = $_POST['status'] ?? '';

        if (is_string($name)) {
            $name = trim($name);
        }

        if (is_string($email)) {
            $email = trim($email);
        }

        try {

            $this->userService->update(
                $id,
                $name,
                $email,
                $role,
                $status
            );

            Flash::set(
                'success',
                'تم تعديل المستخدم بنجاح.'
            );

            header('Location: ?route=users');
            exit;

        } catch (ValidationException $exception) {

            Flash::set(
                'errors',
                $exception->errors()
            );

            Flash::set(
                'old',
                [
                    'name' => $name,
                    'email' => $email,
                    'role' => $role,
                    'status' => $status,
                ]
            );

            header(
                "Location: ?route=users/edit&id={$id}"
            );

            exit;
        }
    }
}