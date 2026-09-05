<?php

use LawFirmManagement\Core\Flash;

$statusLabels = [
    'pending' => 'قيد الانتظار',
    'active' => 'نشطة',
    'on_hold' => 'معلقة',
    'closed' => 'مغلقة',
    'cancelled' => 'ملغاة',
];

$hearingStatusLabels = [
    'scheduled' => 'مجدولة',
    'completed' => 'مكتملة',
    'postponed' => 'مؤجلة',
    'cancelled' => 'ملغاة',
];

$statusBadgeClasses = [
    'pending' => 'bg-yellow-lt text-yellow',
    'active' => 'bg-green-lt text-green',
    'on_hold' => 'bg-orange-lt text-orange',
    'closed' => 'bg-blue-lt text-blue',
    'cancelled' => 'bg-red-lt text-red',
];

$hearingStatusBadgeClasses = [
    'scheduled' => 'bg-blue-lt text-blue',
    'completed' => 'bg-green-lt text-green',
    'postponed' => 'bg-yellow-lt text-yellow',
    'cancelled' => 'bg-red-lt text-red',
];

$oldStatusLabel = static function (?string $status) use ($statusLabels): string {
    if ($status === null || $status === '') {
        return '—';
    }

    return $statusLabels[$status] ?? $status;
};

$pageTitle = 'تفاصيل القضية';

?>

<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container-xl">

    <!-- Page Header -->
    <div class="page-header d-print-none mb-4">

        <div class="row align-items-center">

            <div class="col">

                <div class="page-pretitle">
                    إدارة القضايا
                </div>

                <h2 class="page-title">
                    تفاصيل القضية
                </h2>

            </div>

            <div class="col-auto ms-auto">

                <div class="btn-list">

                    <a
                        href="?route=cases"
                        class="btn btn-outline-secondary"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon"
                        >
                            <path d="M9 6l6 6l-6 6"></path>
                        </svg>

                        العودة إلى القضايا
                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- Case Summary -->
    <div class="row row-cards mb-4">

        <div class="col-lg-8">

            <div class="card h-100">

                <div class="card-header">

                    <h3 class="card-title">
                        معلومات القضية
                    </h3>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <!-- Case Number -->
                        <div class="col-md-6">

                            <div class="text-secondary small mb-1">
                                رقم القضية
                            </div>

                            <div class="fw-semibold">
                                <?= htmlspecialchars(
                                    $case['case_number'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        </div>


                        <!-- Case Title -->
                        <div class="col-md-6">

                            <div class="text-secondary small mb-1">
                                عنوان القضية
                            </div>

                            <div class="fw-semibold">
                                <?= htmlspecialchars(
                                    $case['title'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        </div>


                        <!-- Client -->
                        <div class="col-md-6">

                            <div class="text-secondary small mb-1">
                                العميل
                            </div>

                            <div class="fw-semibold">
                                <?= htmlspecialchars(
                                    $case['client_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        </div>


                        <!-- Lawyer -->
                        <div class="col-md-6">

                            <div class="text-secondary small mb-1">
                                المحامي المسؤول
                            </div>

                            <div class="fw-semibold">
                                <?= htmlspecialchars(
                                    $case['lawyer_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        </div>


                        <!-- Case Type -->
                        <div class="col-md-6">

                            <div class="text-secondary small mb-1">
                                نوع القضية
                            </div>

                            <div class="fw-semibold">
                                <?= htmlspecialchars(
                                    $case['case_type_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        </div>


                        <!-- Filing Date -->
                        <div class="col-md-6">

                            <div class="text-secondary small mb-1">
                                تاريخ القيد
                            </div>

                            <div class="fw-semibold">
                                <?= htmlspecialchars(
                                    $case['filing_date'] ?? '—',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Status & Court -->
        <div class="col-lg-4">

            <div class="card h-100">

                <div class="card-header">

                    <h3 class="card-title">
                        حالة القضية
                    </h3>

                </div>

                <div class="card-body">

                    <div class="mb-4">

                        <div class="text-secondary small mb-2">
                            الحالة الحالية
                        </div>

                        <span
                            class="badge <?= $statusBadgeClasses[$case['status']] ?? 'bg-secondary-lt text-secondary' ?>"
                        >
                            <?= htmlspecialchars(
                                $statusLabels[$case['status']]
                                    ?? $case['status'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </span>

                    </div>


                    <div class="row g-4">

                        <!-- Court -->
                        <div class="col-12">

                            <div class="text-secondary small mb-1">
                                المحكمة
                            </div>

                            <div class="fw-semibold">
                                <?= htmlspecialchars(
                                    $case['court_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        </div>


                        <!-- Court Number -->
                        <div class="col-12">

                            <div class="text-secondary small mb-1">
                                رقم الدائرة
                            </div>

                            <div class="fw-semibold">
                                <?= htmlspecialchars(
                                    $case['court_number'] ?? '—',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Description -->
    <div class="card mb-4">

        <div class="card-header">

            <h3 class="card-title">
                وصف القضية
            </h3>

        </div>

        <div class="card-body">

            <?php if (!empty($case['description'])): ?>

                <div class="text-secondary lh-lg">
                    <?= nl2br(
                        htmlspecialchars(
                            $case['description'],
                            ENT_QUOTES,
                            'UTF-8'
                        )
                    ) ?>
                </div>

            <?php else: ?>

                <div class="empty">

                    <div class="empty-icon">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon"
                        >
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2"></path>
                        </svg>
                    </div>

                    <p class="empty-title">
                        لا يوجد وصف للقضية
                    </p>

                    <p class="empty-subtitle text-secondary">
                        لم تتم إضافة وصف لهذه القضية حتى الآن.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>


    <!-- Status History -->
    <div class="card mb-4">

        <div class="card-header">

            <h3 class="card-title">
                سجل حالات القضية
            </h3>

        </div>

        <?php if (empty($statusHistory)): ?>

            <div class="card-body">

                <div class="empty">

                    <div class="empty-icon">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon"
                        >
                            <path d="M12 8v4l2 2"></path>
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                        </svg>
                    </div>

                    <p class="empty-title">
                        لا يوجد سجل لحالات القضية
                    </p>

                    <p class="empty-subtitle text-secondary">
                        لم يتم تسجيل أي تغييرات على حالة القضية حتى الآن.
                    </p>

                </div>

            </div>

        <?php else: ?>

            <div class="table-responsive">

                <table class="table table-vcenter card-table">

                    <thead>

                        <tr>
                            <th>الحالة السابقة</th>
                            <th>الحالة الجديدة</th>
                            <th>بواسطة</th>
                            <th>التاريخ</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($statusHistory as $history): ?>

                        <tr>

                            <td>

                                <?php
                                $oldStatus = $history['old_status'] ?? null;
                                ?>

                                <?php if ($oldStatus === null || $oldStatus === ''): ?>

                                    <span class="text-secondary">
                                        —
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="badge <?= $statusBadgeClasses[$oldStatus] ?? 'bg-secondary-lt text-secondary' ?>"
                                    >
                                        <?= htmlspecialchars(
                                            $oldStatusLabel($oldStatus),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <?php
                                $newStatus = $history['new_status'] ?? null;
                                ?>

                                <?php if ($newStatus === null || $newStatus === ''): ?>

                                    <span class="text-secondary">
                                        —
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="badge <?= $statusBadgeClasses[$newStatus] ?? 'bg-secondary-lt text-secondary' ?>"
                                    >
                                        <?= htmlspecialchars(
                                            $oldStatusLabel($newStatus),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $history['changed_by_name'] ?? '—',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td class="text-secondary">

                                <?= htmlspecialchars(
                                    $history['changed_at'] ?? '—',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>


    <!-- Hearings -->
    <div class="card mb-4">

        <div class="card-header">

            <div class="row align-items-center w-100">

                <div class="col">

                    <h3 class="card-title mb-1">
                        جلسات القضية
                    </h3>

                    <div class="text-secondary small">
                        <?= count($hearings) ?>
                        <?= count($hearings) === 1 ? 'جلسة' : 'جلسات' ?>
                    </div>

                </div>

                <div class="col-auto">

                    <a
                        href="?route=hearings/create&case_id=<?= (int) $case['id'] ?>"
                        class="btn btn-primary"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon"
                        >
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>

                        إضافة جلسة

                    </a>

                </div>

            </div>

        </div>


        <?php if (empty($hearings)): ?>

            <div class="card-body">

                <div class="empty">

                    <div class="empty-icon">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon"
                        >
                            <path d="M12 8v4l2 2"></path>
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                        </svg>
                    </div>

                    <p class="empty-title">
                        لا توجد جلسات لهذه القضية
                    </p>

                    <p class="empty-subtitle text-secondary">
                        لم تتم إضافة أي جلسات لهذه القضية حتى الآن.
                    </p>

                </div>

            </div>

        <?php else: ?>

            <div class="table-responsive">

                <table class="table table-vcenter card-table">

                    <thead>

                        <tr>
                            <th>التاريخ</th>
                            <th>الوقت</th>
                            <th>المحكمة</th>
                            <th>رقم الدائرة</th>
                            <th>نوع الجلسة</th>
                            <th>الحالة</th>
                            <th>الملاحظات</th>
                            <th class="w-1">إجراء</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($hearings as $hearing): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars(
                                    $hearing['hearing_date'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $hearing['hearing_time'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $hearing['court_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $hearing['court_number'] ?? '—',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $hearing['hearing_type'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>


                            <td>

                                <span
                                    class="badge <?= $hearingStatusBadgeClasses[$hearing['status']] ?? 'bg-secondary-lt text-secondary' ?>"
                                >
                                    <?= htmlspecialchars(
                                        $hearingStatusLabels[
                                            $hearing['status']
                                        ] ?? $hearing['status'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </span>

                            </td>


                            <td>

                                <?php if (!empty($hearing['notes'])): ?>

                                    <div class="text-secondary">
                                        <?= nl2br(
                                            htmlspecialchars(
                                                $hearing['notes'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                        ) ?>
                                    </div>

                                <?php else: ?>

                                    <span class="text-secondary">
                                        —
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <a
                                    href="?route=hearings/edit&id=<?= (int) $hearing['id'] ?>"
                                    class="btn btn-sm btn-outline-primary"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-sm"
                                    >
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                                        <path d="M13.5 6.5l4 4"></path>
                                    </svg>

                                    تعديل

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>


    <!-- Bottom Actions -->
    <div class="d-print-none mb-4">

        <div class="card">

            <div class="card-body">

                <div class="btn-list">

                    <a
                        href="?route=cases/documents&id=<?= (int) $case['id'] ?>"
                        class="btn btn-primary"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon"
                        >
                            <path d="M5 4h14a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1"></path>
                            <path d="M9 8h6"></path>
                            <path d="M9 12h6"></path>
                            <path d="M9 16h4"></path>
                        </svg>

                        مستندات القضية

                    </a>


                    <a
                        href="?route=cases"
                        class="btn btn-outline-secondary"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon"
                        >
                            <path d="M9 6l6 6l-6 6"></path>
                        </svg>

                        العودة إلى القضايا

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>