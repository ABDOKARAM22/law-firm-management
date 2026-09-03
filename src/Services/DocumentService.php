<?php

namespace LawFirmManagement\Services;

use LawFirmManagement\Repositories\DocumentRepository;
use LawFirmManagement\Repositories\CaseRepository;
use LawFirmManagement\Core\Validator;
use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Core\Auth;
use LawFirmManagement\Services\CaseAccessService;

class DocumentService
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private CaseRepository $caseRepository,
        private Auth $auth,
        private CaseAccessService $caseAccessService
    ) {
    }

    public function find(int $id): array|false
    {
        return $this->documentRepository->findById($id);
    }

    public function allByCaseId(int $caseId): array
    {
        $case = $this->caseRepository->findById($caseId);

        if ($case === false) {
            throw new ValidationException([
                'case_id' => 'القضية غير موجودة.',
            ]);
        }

        if (!$this->caseAccessService->canAccess($caseId)) {
            throw new ValidationException([
                'case_id' => 'ليس لديك صلاحية للوصول إلى مستندات هذه القضية.',
            ]);
        }

        return $this->documentRepository->allByCaseId($caseId);
    }
    
    public function getCase(int $caseId): array|false
    {
        $case = $this->caseRepository->findById($caseId);

        if ($case === false) {
            throw new ValidationException([
                'case_id' => 'القضية غير موجودة.',
            ]);
        }

        if (!$this->caseAccessService->canAccess($caseId)) {
            throw new ValidationException([
                'case_id' => 'ليس لديك صلاحية للوصول إلى هذه القضية.',
            ]);
        }

        return $case;
    }

    public function create(
        mixed $caseId,
        mixed $title,
        mixed $file
    ): int {
        $validator = new Validator();

        $validator
            ->required('case_id', $caseId)
            ->integer('case_id', $caseId)
            ->required('title', $title)
            ->string('title', $title);

        if ($validator->fails()) {
            throw new ValidationException(
                $validator->errors()
            );
        }

        $caseId = (int) $caseId;

        $case = $this->caseRepository->findById($caseId);

        if ($case === false) {
            throw new ValidationException([
                'case_id' => 'القضية غير موجودة.',
            ]);
        }

        if (!$this->caseAccessService->canAccess($caseId)) {
            throw new ValidationException([
                'case_id' => 'ليس لديك صلاحية للتعامل مع هذه القضية.',
            ]);
        }

        if (
            !is_array($file) ||
            !isset(
                $file['error'],
                $file['tmp_name'],
                $file['name'],
                $file['size']
            )
        ) {
            throw new ValidationException([
                'file' => 'الملف غير صالح.',
            ]);
        }

        $fileData = $this->validateFile($file);

        $mimeType = $fileData['mime_type'];
        $extension = $fileData['extension'];

        $storedFileName =
            bin2hex(random_bytes(16)) . '.' . $extension;

        $storageDirectory =
            dirname(__DIR__, 2) . '/storage/documents';

        if (!is_dir($storageDirectory)) {
            if (
                !mkdir($storageDirectory, 0755, true) &&
                !is_dir($storageDirectory)
            ) {
                throw new ValidationException([
                    'file' => 'تعذر إنشاء مجلد تخزين الملفات.',
                ]);
            }
        }

        $destination =
            $storageDirectory . '/' . $storedFileName;

        $filePath =
            'storage/documents/' . $storedFileName;

        if (!move_uploaded_file(
            $file['tmp_name'],
            $destination
        )) {
            throw new ValidationException([
                'file' => 'فشل في حفظ الملف.',
            ]);
        }

        $user = $this->auth->user();

        if ($user === null) {
            if (is_file($destination)) {
                unlink($destination);
            }

            throw new ValidationException([
                'document' => 'يجب تسجيل الدخول.',
            ]);
        }

        $uploadedBy = (int) $user['id'];

        try {
            $documentId = $this->documentRepository->create(
                $caseId,
                $title,
                $file['name'],
                $filePath,
                $mimeType,
                (int) $file['size'],
                $uploadedBy
            );
        } catch (\Throwable $exception) {

            if (is_file($destination)) {
                unlink($destination);
            }

            throw $exception;
        }

        return $documentId;
    }

    public function getForDownload(int $id): array
    {
        $document = $this->documentRepository->findById($id);

        if ($document === false) {
            throw new ValidationException([
                'document' => 'المستند غير موجود.',
            ]);
        }

        if (
            !$this->caseAccessService->canAccess(
                (int) $document['case_id']
            )
        ) {
            throw new ValidationException([
                'document' => 'ليس لديك صلاحية للوصول إلى هذا المستند.',
            ]);
        }

        return $document;
    }

    public function getForEdit(int $id): array
    {
        $document = $this->documentRepository->findById($id);

        if ($document === false) {
            throw new ValidationException([
                'document' => 'المستند غير موجود.',
            ]);
        }

        if (
            !$this->caseAccessService->canAccess(
                (int) $document['case_id']
            )
        ) {
            throw new ValidationException([
                'document' => 'ليس لديك صلاحية لتعديل هذا المستند.',
            ]);
        }

        return $document;
    }

    public function update(
        int $id,
        string $title,
        ?array $file
    ): void {
        $document = $this->getForEdit($id);

        $validator = new Validator();

        $validator
            ->required('title', $title)
            ->string('title', $title);

        if ($validator->fails()) {
            throw new ValidationException(
                $validator->errors()
            );
        }

        $fileName = $document['file_name'];
        $filePath = $document['file_path'];
        $fileType = $document['file_type'];
        $fileSize = (int) $document['file_size'];

        $destination = null;

        if ($file !== null) {

            $fileData = $this->validateFile($file);

            $mimeType = $fileData['mime_type'];
            $extension = $fileData['extension'];

            $storedFileName =
                bin2hex(random_bytes(16)) . '.' . $extension;

            $storageDirectory =
                dirname(__DIR__, 2) . '/storage/documents';

            if (!is_dir($storageDirectory)) {
                if (
                    !mkdir($storageDirectory, 0755, true) &&
                    !is_dir($storageDirectory)
                ) {
                    throw new ValidationException([
                        'file' => 'تعذر إنشاء مجلد تخزين الملفات.',
                    ]);
                }
            }

            $destination =
                $storageDirectory . '/' . $storedFileName;

            $fileName = $file['name'];
            $filePath =
                'storage/documents/' . $storedFileName;
            $fileType = $mimeType;
            $fileSize = (int) $file['size'];

            if (!move_uploaded_file(
                $file['tmp_name'],
                $destination
            )) {
                throw new ValidationException([
                    'file' => 'فشل حفظ الملف.',
                ]);
            }
        }

        try {
            $this->documentRepository->update(
                $id,
                $title,
                $fileName,
                $filePath,
                $fileType,
                $fileSize
            );
        } catch (\Throwable $exception) {

            if (
                $destination !== null &&
                is_file($destination)
            ) {
                unlink($destination);
            }

            throw $exception;
        }

        if ($destination !== null) {

            $oldFilePath =
                dirname(__DIR__, 2) . '/' .
                $document['file_path'];

            if (
                $oldFilePath !== $destination &&
                is_file($oldFilePath)
            ) {
                unlink($oldFilePath);
            }
        }
    }

    public function delete(int $id): void
    {
        $document = $this->getForEdit($id);

        $filePath =
            dirname(__DIR__, 2) . '/' .
            $document['file_path'];

        $this->documentRepository->delete($id);

        if (is_file($filePath)) {
            unlink($filePath);
        }
    }

    private function validateFile(array $file): array
    {
        if (
            $file['error'] !== UPLOAD_ERR_OK
        ) {
            throw new ValidationException([
                'file' => 'حدث خطأ أثناء رفع الملف.',
            ]);
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new ValidationException([
                'file' => 'الملف المرفوع غير صالح.',
            ]);
        }

        $allowedMimeTypes = [
            'application/pdf',
            'image/jpeg',
            'image/png',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        $finfo = new \finfo(FILEINFO_MIME_TYPE);

        $mimeType = $finfo->file(
            $file['tmp_name']
        );

        if ($mimeType === false) {
            throw new ValidationException([
                'file' => 'تعذر تحديد نوع الملف.',
            ]);
        }

        if (!in_array(
            $mimeType,
            $allowedMimeTypes,
            true
        )) {
            throw new ValidationException([
                'file' => 'نوع الملف غير مسموح به.',
            ]);
        }

        $maxFileSize = 5 * 1024 * 1024;

        if ($file['size'] > $maxFileSize) {
            throw new ValidationException([
                'file' => 'حجم الملف يجب ألا يتجاوز 5 ميجابايت.',
            ]);
        }

        $extension = strtolower(
            pathinfo(
                $file['name'],
                PATHINFO_EXTENSION
            )
        );

        return [
            'mime_type' => $mimeType,
            'extension' => $extension,
        ];
    }
}