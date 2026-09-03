<?php

namespace LawFirmManagement\Controllers;

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Services\DocumentService;

class DocumentController
{
    public function __construct(
        private DocumentService $documentService,
    ) {
    }

    public function index(int $caseId): void
    {
        $documents = $this->documentService->allByCaseId($caseId);

        require __DIR__ . '/../Views/documents/index.php';
    }

    public function create(int $caseId): void
    {
        $case = $this->documentService->getCase($caseId);

        require __DIR__ . '/../Views/documents/create.php';
    } 

    public function store(int $caseId): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        $title = $_POST['title'] ?? '';

        if (is_string($title)) {
            $title = trim($title);
        }

        $file = $_FILES['file'] ?? null;

            try {
        $this->documentService->create(
            $caseId,
            $title,
            $file
        );

        Flash::set(
            'success',
            'تم رفع المستند بنجاح.'
        );

        header(
            'Location: ?route=cases/documents&id=' . $caseId
        );

        exit;

    } catch (ValidationException $exception) {

        Flash::set(
            'errors',
            $exception->errors()
        );

        Flash::set(
            'old',
            [
                'title' => $title,
            ]
        );

        header(
            'Location: ?route=documents/create&case_id=' . $caseId
        );

        exit;
    }
    }


    public function download(int $id): void
    {
        try {
            $document = $this->documentService->getForDownload($id);

            $filePath = dirname(__DIR__, 2) . '/' . $document['file_path'];

            if (!is_file($filePath)) {
                http_response_code(404);
                echo 'الملف غير موجود.';
                return;
            }

            header('Content-Type: ' . $document['file_type']);
            header(
                'Content-Disposition: attachment; filename="' .
                basename($document['file_name']) .
                '"'
            );
            header('Content-Length: ' . filesize($filePath));

            readfile($filePath);

        } catch (ValidationException $exception) {

            http_response_code(403);
            echo htmlspecialchars(
                $exception->errors()['document'] ?? 'لا يمكن تحميل المستند.'
            );
        }
    }

    public function edit(int $id): void
    {
        $document = $this->documentService->getForEdit($id);

        require __DIR__ . '/../Views/documents/edit.php';
    }


    public function update(int $id): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        $title = $_POST['title'] ?? '';

        if (is_string($title)) {
            $title = trim($title);
        }

        $file = $_FILES['file'] ?? null;

        if (
            is_array($file) &&
            ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE
        ) {
            $file = null;
        }

        try {

            $this->documentService->update(
                $id,
                $title,
                $file
            );

            Flash::set(
                'success',
                'تم تعديل المستند بنجاح.'
            );

            header(
                'Location: ?route=cases/documents&id=' .
                $this->documentService->find($id)['case_id']
            );

            exit;

        } catch (ValidationException $exception) {

            Flash::set(
                'errors',
                $exception->errors()
            );

            Flash::set(
                'old',
                [
                    'title' => $title,
                ]
            );

            header(
                'Location: ?route=documents/edit&id=' . $id
            );

            exit;
        }
    }


    public function delete(int $id): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        try {

            $document = $this->documentService->find($id);

            if ($document === false) {
                http_response_code(404);
                echo 'المستند غير موجود.';
                return;
            }

            $this->documentService->delete($id);

            Flash::set(
                'success',
                'تم حذف المستند بنجاح.'
            );

            header(
                'Location: ?route=cases/documents&id=' .
                $document['case_id']
            );

            exit;

        } catch (ValidationException $exception) {

            Flash::set(
                'errors',
                $exception->errors()
            );

            header(
                'Location: ?route=cases/documents&id=' .
                ($document['case_id'] ?? '')
            );

            exit;
        }
    }

}