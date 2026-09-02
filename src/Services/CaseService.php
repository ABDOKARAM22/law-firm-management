<?php

namespace LawFirmManagement\Services;

use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Core\Validator;
use LawFirmManagement\Repositories\CaseRepository;
use LawFirmManagement\Repositories\ClientRepository;
use LawFirmManagement\Repositories\UserRepository;
use LawFirmManagement\Repositories\CaseTypeRepository;
use LawFirmManagement\Repositories\CaseStatusHistoryRepository;
use PDO;

class CaseService
{
    public function __construct(
        private CaseRepository $caseRepository,
        private ClientRepository $clientRepository,
        private UserRepository $userRepository,
        private CaseTypeRepository $caseTypeRepository,
        private CaseStatusHistoryRepository $caseStatusHistoryRepository,
        private PDO $pdo
    ) {
    }

    public function all(): array
    {
        return $this->caseRepository->all();
    }

    public function find(int $id): array|false
    {
        return $this->caseRepository->findById($id);
    }   



    public function update(
        int $id,
        mixed $caseNumber,
        mixed $title,
        mixed $clientId,
        mixed $assignedLawyerId,
        mixed $caseTypeId,
        mixed $courtName,
        mixed $courtNumber,
        mixed $status,
        mixed $description,
        mixed $filingDate,
        int $changedBy
    ): void {
        $case = $this->caseRepository->findById($id);

        if ($case === false) {
            throw new ValidationException([
                'case' => 'القضية غير موجودة.'
            ]);
        }

        $validator = new Validator();

        $validator
            ->required('case_number', $caseNumber)
            ->string('case_number', $caseNumber)

            ->required('title', $title)
            ->string('title', $title)
            ->alpha('title', $title)


            ->required('client_id', $clientId)
            ->integer('client_id', $clientId)

            ->required('assigned_lawyer_id', $assignedLawyerId)
            ->integer('assigned_lawyer_id', $assignedLawyerId)

            ->required('case_type_id', $caseTypeId)
            ->integer('case_type_id', $caseTypeId)

            ->required('court_name', $courtName)
            ->string('court_name', $courtName)
            ->alpha('court_name', $courtName)

            ->string('court_number', $courtNumber)
            ->string('description', $description)

            ->required('status', $status)
            ->in('status', $status, [
                'pending',
                'active',
                'on_hold',
                'closed',
                'cancelled',
            ])

            ->string('filing_date', $filingDate);

        if ($validator->fails()) {
            throw new ValidationException(
                $validator->errors()
            );
        }

        $clientId = (int) $clientId;
        $assignedLawyerId = (int) $assignedLawyerId;
        $caseTypeId = (int) $caseTypeId;

        if ($this->caseRepository->existsByCaseNumberExceptId(
            $caseNumber,
            $id
        )) {
            throw new ValidationException([
                'case_number' => 'رقم القضية مستخدم بالفعل.'
            ]);
        }

        $client = $this->clientRepository->findById($clientId);

        if ($client === false) {
            throw new ValidationException([
                'client_id' => 'العميل غير موجود.'
            ]);
        }

        $lawyer = $this->userRepository->findActiveLawyerById(
            $assignedLawyerId
        );

        if ($lawyer === false) {
            throw new ValidationException([
                'assigned_lawyer_id' =>
                    'المحامي غير موجود أو غير نشط.'
            ]);
        }

        $caseType = $this->caseTypeRepository->findById($caseTypeId);

        if ($caseType === false) {
            throw new ValidationException([
                'case_type_id' =>
                    'نوع القضية غير موجود أو غير نشط.'
            ]);
        }

        $oldStatus = $case['status'];

        $this->pdo->beginTransaction();

        try {
            $this->caseRepository->update(
                $id,
                $caseNumber,
                $title,
                $clientId,
                $assignedLawyerId,
                $caseTypeId,
                $courtName,
                $courtNumber ?: null,
                $status,
                $description ?: null,
                $filingDate ?: null
            );

            if ($oldStatus !== $status) {
                $this->caseStatusHistoryRepository->create(
                    $id,
                    $oldStatus,
                    $status,
                    $changedBy
                );
            }

            $this->pdo->commit();

        } catch (\Throwable $exception) {

            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $exception;
        }
    }




    public function create(
        mixed $caseNumber,
        mixed $title,
        mixed $clientId,
        mixed $assignedLawyerId,
        mixed $caseTypeId,
        mixed $courtName,
        mixed $courtNumber,
        mixed $status,
        mixed $description,
        mixed $filingDate,
        int $changedBy
    ): void {
        $validator = new Validator();

        $validator
            ->required('case_number', $caseNumber)
            ->string('case_number', $caseNumber)

            ->required('title', $title)
            ->string('title', $title)
            ->alpha('title', $title)

            ->required('client_id', $clientId)
            ->integer('client_id', $clientId)

            ->required('assigned_lawyer_id', $assignedLawyerId)
            ->integer('assigned_lawyer_id', $assignedLawyerId)

            ->required('case_type_id', $caseTypeId)
            ->integer('case_type_id', $caseTypeId)

            ->required('court_name', $courtName)
            ->string('court_name', $courtName)
            ->alpha('court_name', $courtName)

            ->string('court_number', $courtNumber)
            ->string('description', $description)

            ->required('status', $status)
            ->in('status', $status, [
                'pending',
                'active',
                'on_hold',
                'closed',
                'cancelled',
            ])

            ->string('filing_date', $filingDate);
            
            if ($validator->fails()) {
                throw new ValidationException(
                    $validator->errors()
                );
            }

            
            $clientId = (int) $clientId;
            $assignedLawyerId = (int) $assignedLawyerId;
            $caseTypeId = (int) $caseTypeId;



            if ($this->caseRepository->existsByCaseNumber($caseNumber)) {
                throw new ValidationException([
                    'case_number' => 'رقم القضية مستخدم بالفعل.'
                ]);
            }


            $client = $this->clientRepository->findById($clientId);

            if ($client === false) {
                throw new ValidationException([
                    'client_id' => 'العميل غير موجود.'
                ]);
            }


            $lawyer = $this->userRepository->findActiveLawyerById($assignedLawyerId);

            if ($lawyer === false) {
                throw new ValidationException([
                    'assigned_lawyer_id' =>
                        'المحامي غير موجود أو غير نشط.'
                ]);
            }


            $caseType = $this->caseTypeRepository->findById($caseTypeId);

            if ($caseType === false) {
                throw new ValidationException([
                    'case_type_id' => 'نوع القضية غير موجود أو غير نشط.'
                ]);
            }

            $this->pdo->beginTransaction();

            try {

                $caseId = $this->caseRepository->create(
                    $caseNumber,
                    $title,
                    $clientId,
                    $assignedLawyerId,
                    $caseTypeId,
                    $courtName,
                    $courtNumber ?: null,
                    $status,
                    $description ?: null,
                    $filingDate ?: null,
                );

                $this->caseStatusHistoryRepository->create(
                    $caseId,
                    null,
                    $status,
                    $changedBy
                );

                $this->pdo->commit();

            } catch (\Throwable $exception) {

                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }

                throw $exception;
            }
                                
                                
    }

}