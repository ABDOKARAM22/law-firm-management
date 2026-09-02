<?php

namespace LawFirmManagement\Controllers;

use LawFirmManagement\Core\Auth;
use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Services\CaseService;
use LawFirmManagement\Services\HearingService;
use LawFirmManagement\Services\CaseAccessService;


class HearingController
{
    public function __construct(
        private HearingService $hearingService,
        private CaseService $caseService,
        private Auth $auth,
        private CaseAccessService $caseAccessService

    ) {
    }

    public function create(int $caseId): void
    {
        $case = $this->caseService->find($caseId);
        
        if ($case === false) {
            http_response_code(404);
            echo 'Case not found';
            return;
            }

            
        if (!$this->caseAccessService->canAccess($caseId)) {
            http_response_code(403);
            echo 'ليس لديك صلاحية للوصول إلى هذه القضية.';
            return;
        }

        require __DIR__ . '/../Views/hearings/create.php';
    }

    public function store(int $caseId): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        if (!$this->caseAccessService->canAccess($caseId)) {
        http_response_code(403);
        echo 'ليس لديك صلاحية للوصول إلى هذه القضية.';
        return;
       }

        $hearingDate = $_POST['hearing_date'] ?? '';
        $hearingTime = $_POST['hearing_time'] ?? '';
        $courtName = $_POST['court_name'] ?? '';
        $courtNumber = $_POST['court_number'] ?? '';
        $hearingType = $_POST['hearing_type'] ?? '';
        $status = $_POST['status'] ?? 'scheduled';
        $notes = $_POST['notes'] ?? '';

        $values = [
            &$hearingDate,
            &$hearingTime,
            &$courtName,
            &$courtNumber,
            &$hearingType,
            &$status,
            &$notes,
        ];

        foreach ($values as &$value) {
            if (is_string($value)) {
                $value = trim($value);
            }
        }

        try {
            $this->hearingService->create(
                $caseId,
                $hearingDate,
                $hearingTime,
                $courtName,
                $courtNumber,
                $hearingType,
                $status,
                $notes
            );

            Flash::set(
                'success',
                'تم إضافة الجلسة بنجاح.'
            );

            header("Location: ?route=cases/show&id={$caseId}");
            exit;

        } catch (ValidationException $exception) {

            Flash::set(
                'errors',
                $exception->errors()
            );

            Flash::set('old', [
                'hearing_date' => $hearingDate,
                'hearing_time' => $hearingTime,
                'court_name' => $courtName,
                'court_number' => $courtNumber,
                'hearing_type' => $hearingType,
                'status' => $status,
                'notes' => $notes,
            ]);

            header(
                "Location: ?route=hearings/create&case_id={$caseId}"
            );
            exit;
        }
    }



    public function edit(int $id): void
    {
        $hearing = $this->hearingService->find($id);

        if ($hearing === false) {
            http_response_code(404);
            echo 'Hearing not found';
            return;
        }

        $caseId = (int) $hearing['case_id'];

        if (!$this->caseAccessService->canAccess($caseId)) {
            http_response_code(403);
            echo 'ليس لديك صلاحية لتعديل هذه الجلسة.';
            return;
        }

        $case = $this->caseService->find($caseId);

        if ($case === false) {
            http_response_code(404);
            echo 'Case not found';
            return;
        }

        require __DIR__ . '/../Views/hearings/edit.php';
    }



    public function update(int $id): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        $hearing = $this->hearingService->find($id);

        if ($hearing === false) {
            http_response_code(404);
            echo 'Hearing not found';
            return;
        }

        $caseId = (int) $hearing['case_id'];

        if (!$this->caseAccessService->canAccess($caseId)) {
            http_response_code(403);
            echo 'ليس لديك صلاحية لتعديل هذه الجلسة.';
            return;
        }

        $hearingDate = $_POST['hearing_date'] ?? '';
        $hearingTime = $_POST['hearing_time'] ?? '';
        $courtName = $_POST['court_name'] ?? '';
        $courtNumber = $_POST['court_number'] ?? '';
        $hearingType = $_POST['hearing_type'] ?? '';
        $status = $_POST['status'] ?? '';
        $notes = $_POST['notes'] ?? '';

        $values = [
            &$hearingDate,
            &$hearingTime,
            &$courtName,
            &$courtNumber,
            &$hearingType,
            &$status,
            &$notes,
        ];

        foreach ($values as &$value) {
            if (is_string($value)) {
                $value = trim($value);
            }
        }

        try {
            $this->hearingService->update(
                $id,
                $hearingDate,
                $hearingTime,
                $courtName,
                $courtNumber,
                $hearingType,
                $status,
                $notes
            );

            Flash::set(
                'success',
                'تم تحديث الجلسة بنجاح.'
            );

            header("Location: ?route=cases/show&id={$caseId}");
            exit;

        } catch (ValidationException $exception) {

            Flash::set(
                'errors',
                $exception->errors()
            );

            Flash::set('old', [
                'hearing_date' => $hearingDate,
                'hearing_time' => $hearingTime,
                'court_name' => $courtName,
                'court_number' => $courtNumber,
                'hearing_type' => $hearingType,
                'status' => $status,
                'notes' => $notes,
            ]);

            header(
                "Location: ?route=hearings/edit&id={$id}"
            );
            exit;
        }
    }
    
}