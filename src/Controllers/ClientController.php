<?php

namespace LawFirmManagement\Controllers;

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Services\ClientService;

class ClientController
{
    public function __construct(
        private ClientService $clientService
    ) {
    }

    public function index(): void
    {
        $clients = $this->clientService->all();

        require __DIR__ . '/../Views/clients/index.php';
    }

    public function create(): void
    {
        require __DIR__ . '/../Views/clients/create.php';
    }

    public function store(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        $name = $_POST['name'] ?? '';
        $nationalId = $_POST['national_id'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';
        $status = $_POST['status'] ?? '';

        if (is_string($name)) {
            $name = trim($name);
        }

        if (is_string($nationalId)) {
            $nationalId = trim($nationalId);
        }

        if (is_string($phone)) {
            $phone = trim($phone);
        }

        if (is_string($email)) {
            $email = trim($email);
        }

        if (is_string($address)) {
            $address = trim($address);
        }

        if (is_string($status)) {
            $status = trim($status);
        }

        try {

            $this->clientService->create(
                $name,
                $nationalId,
                $phone,
                $email,
                $address,
                $status
            );

            Flash::set(
                'success',
                'تم إضافة العميل بنجاح.'
            );

            header('Location: ?route=clients');
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
                    'national_id' => $nationalId,
                    'phone' => $phone,
                    'email' => $email,
                    'address' => $address,
                    'status' => $status,
                ]
            );

            header('Location: ?route=clients/create');
            exit;
        }
    }
}