<?php

namespace LawFirmManagement\Services;

use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Core\Validator;
use LawFirmManagement\Repositories\CaseRepository;
use LawFirmManagement\Repositories\HearingRepository;

class HearingService
{
    public function __construct(
        private HearingRepository $hearingRepository,
        private CaseRepository $caseRepository
    ) {
    }


    public function allByCaseId(int $caseId): array
    {
        $case = $this->caseRepository->findById($caseId);

        if ($case === false) {
            throw new ValidationException([
                'case_id' => 'القضية غير موجودة.'
            ]);
        }

        return $this->hearingRepository->allByCaseId($caseId);
    }



    public function find(int $id): array|false
    {
        return $this->hearingRepository->findById($id);
    }


    public function create(
        mixed $caseId,
        mixed $hearingDate,
        mixed $hearingTime,
        mixed $courtName,
        mixed $courtNumber,
        mixed $hearingType,
        mixed $status,
        mixed $notes
    ): int {
        $validator = new Validator();

        $validator
            ->required('case_id', $caseId)
            ->integer('case_id', $caseId)

            ->required('hearing_date', $hearingDate)
            ->string('hearing_date', $hearingDate)

            ->required('hearing_time', $hearingTime)
            ->string('hearing_time', $hearingTime)

            ->required('court_name', $courtName)
            ->string('court_name', $courtName)
            ->alpha('court_name', $courtName)

            ->string('court_number', $courtNumber)

            ->required('hearing_type', $hearingType)
            ->string('hearing_type', $hearingType)
            ->alpha('hearing_type', $hearingType)

            ->required('status', $status)
            ->in('status', $status, [
                'scheduled',
                'completed',
                'postponed',
                'cancelled',
            ])

            ->string('notes', $notes);

        if ($validator->fails()) {
            throw new ValidationException(
                $validator->errors()
            );
        }

        $caseId = (int) $caseId;

        $case = $this->caseRepository->findById($caseId);

        if ($case === false) {
            throw new ValidationException([
                'case_id' => 'القضية غير موجودة.'
            ]);
        }

        return $this->hearingRepository->create(
            $caseId,
            $hearingDate,
            $hearingTime,
            $courtName,
            $courtNumber ?: null,
            $hearingType,
            $status,
            $notes ?: null
        );
    }

    public function update(
        int $id,
        mixed $hearingDate,
        mixed $hearingTime,
        mixed $courtName,
        mixed $courtNumber,
        mixed $hearingType,
        mixed $status,
        mixed $notes
    ): void {
        $hearing = $this->hearingRepository->findById($id);

        if ($hearing === false) {
            throw new ValidationException([
                'hearing' => 'الجلسة غير موجودة.'
            ]);
        }

        $validator = new Validator();

        $validator
            ->required('hearing_date', $hearingDate)
            ->string('hearing_date', $hearingDate)

            ->required('hearing_time', $hearingTime)
            ->string('hearing_time', $hearingTime)

            ->required('court_name', $courtName)
            ->string('court_name', $courtName)

            ->string('court_number', $courtNumber)

            ->required('hearing_type', $hearingType)
            ->string('hearing_type', $hearingType)

            ->required('status', $status)
            ->in('status', $status, [
                'scheduled',
                'completed',
                'postponed',
                'cancelled',
            ])

            ->string('notes', $notes);

        if ($validator->fails()) {
            throw new ValidationException(
                $validator->errors()
            );
        }

        $this->hearingRepository->update(
            $id,
            $hearingDate,
            $hearingTime,
            $courtName,
            $courtNumber ?: null,
            $hearingType,
            $status,
            $notes ?: null
        );
    }
}