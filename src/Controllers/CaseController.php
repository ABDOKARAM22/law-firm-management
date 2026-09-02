<?php

namespace LawFirmManagement\Controllers;

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Services\CaseService;
use LawFirmManagement\Repositories\CaseTypeRepository;
use LawFirmManagement\Repositories\UserRepository;
use LawFirmManagement\Services\ClientService;
use LawFirmManagement\Core\Auth;

class CaseController
{
    public function __construct(
        private CaseService $caseService,
        private ClientService $clientService,
        private UserRepository $userRepository,
        private CaseTypeRepository $caseTypeRepository,
        private Auth $auth
    ) {
    }

    public function index(): void
    {
        $cases = $this->caseService->all();

        require __DIR__ . '/../Views/cases/index.php';
    }

    public function create(): void
    {
        $clients = $this->clientService->all();

        $lawyers = $this->userRepository->allActiveLawyers();

        $caseTypes = $this->caseTypeRepository->all();

        require __DIR__ . '/../Views/cases/create.php';
    }


        public function edit(int $id): void
    {
        $case = $this->caseService->find($id);

        if ($case === false) {
            http_response_code(404);
            echo 'Case not found';
            return;
        }

        $clients = $this->clientService->all();

        $lawyers = $this->userRepository->allActiveLawyers();

        $caseTypes = $this->caseTypeRepository->all();

        require __DIR__ . '/../Views/cases/edit.php';
    }



    public function store(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        $caseNumber = $_POST['case_number'] ?? '';
        $title = $_POST['title'] ?? '';
        $clientId = $_POST['client_id'] ?? '';
        $assignedLawyerId = $_POST['assigned_lawyer_id'] ?? '';
        $caseTypeId = $_POST['case_type_id'] ?? '';
        $courtName = $_POST['court_name'] ?? '';
        $courtNumber = $_POST['court_number'] ?? '';
        $status = $_POST['status'] ?? 'pending';
        $description = $_POST['description'] ?? '';
        $filingDate = $_POST['filing_date'] ?? '';

        $values = [
            &$caseNumber,
            &$title,
            &$clientId,
            &$assignedLawyerId,
            &$caseTypeId,
            &$courtName,
            &$courtNumber,
            &$status,
            &$description,
            &$filingDate,
        ];

        foreach ($values as &$value) {
            if (is_string($value)) {
                $value = trim($value);
            }
        }

        $changedBy = $this->auth->id();

        if ($changedBy === null) {
            http_response_code(401);
            return;
        }
        
        try {

            $this->caseService->create(
                $caseNumber,
                $title,
                $clientId,
                $assignedLawyerId,
                $caseTypeId,
                $courtName,
                $courtNumber,
                $status,
                $description,
                $filingDate,
                $changedBy
            );

            Flash::set(
                'success',
                'تم إنشاء القضية بنجاح.'
            );

            header('Location: ?route=cases');
            exit;

        } catch (ValidationException $exception) {

            Flash::set(
                'errors',
                $exception->errors()
            );

            Flash::set(
                'old',
                [
                    'case_number' => $caseNumber,
                    'title' => $title,
                    'client_id' => $clientId,
                    'assigned_lawyer_id' => $assignedLawyerId,
                    'case_type_id' => $caseTypeId,
                    'court_name' => $courtName,
                    'court_number' => $courtNumber,
                    'status' => $status,
                    'description' => $description,
                    'filing_date' => $filingDate,
                ]
            );

            header('Location: ?route=cases/create');
            exit;
        }
    }


    public function update(int $id): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        $caseNumber = $_POST['case_number'] ?? '';
        $title = $_POST['title'] ?? '';
        $clientId = $_POST['client_id'] ?? '';
        $assignedLawyerId = $_POST['assigned_lawyer_id'] ?? '';
        $caseTypeId = $_POST['case_type_id'] ?? '';
        $courtName = $_POST['court_name'] ?? '';
        $courtNumber = $_POST['court_number'] ?? '';
        $status = $_POST['status'] ?? '';
        $description = $_POST['description'] ?? '';
        $filingDate = $_POST['filing_date'] ?? '';

        $values = [
            &$caseNumber,
            &$title,
            &$clientId,
            &$assignedLawyerId,
            &$caseTypeId,
            &$courtName,
            &$courtNumber,
            &$status,
            &$description,
            &$filingDate,
        ];

        foreach ($values as &$value) {
            if (is_string($value)) {
                $value = trim($value);
            }
        }

        $changedBy = $this->auth->id();

        if ($changedBy === null) {
            http_response_code(401);
            return;
        }

        try {

            $this->caseService->update(
                $id,
                $caseNumber,
                $title,
                $clientId,
                $assignedLawyerId,
                $caseTypeId,
                $courtName,
                $courtNumber,
                $status,
                $description,
                $filingDate,
                $changedBy
            );

            Flash::set(
                'success',
                'تم تحديث القضية بنجاح.'
            );

            header('Location: ?route=cases');
            exit;

        } catch (ValidationException $exception) {

            Flash::set(
                'errors',
                $exception->errors()
            );

            Flash::set(
                'old',
                [
                    'case_number' => $caseNumber,
                    'title' => $title,
                    'client_id' => $clientId,
                    'assigned_lawyer_id' => $assignedLawyerId,
                    'case_type_id' => $caseTypeId,
                    'court_name' => $courtName,
                    'court_number' => $courtNumber,
                    'status' => $status,
                    'description' => $description,
                    'filing_date' => $filingDate,
                ]
            );

            header("Location: ?route=cases/edit&id={$id}");
            exit;
        }
    }

    
    public function show(int $id): void
    {
        $case = $this->caseService->find($id);

        if ($case === false) {
            http_response_code(404);
            echo 'Case not found';
            return;
        }

        $statusHistory = $this->caseService->statusHistory($id);

        require __DIR__ . '/../Views/cases/show.php';
    }

}