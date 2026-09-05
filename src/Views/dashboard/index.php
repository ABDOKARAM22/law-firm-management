<?php

use LawFirmManagement\Core\Flash;

$pageTitle = 'لوحة التحكم';

require __DIR__ . '/../layouts/header.php';

$success = Flash::get('success');

$roleLabels = [
    'admin' => 'مدير النظام',
    'staff' => 'موظف',
    'lawyer' => 'محامي',
];

$roleLabel = $roleLabels[$user['role']] ?? $user['role'];

$caseStatusLabels = [
    'pending' => 'قيد الانتظار',
    'active' => 'نشطة',
    'on_hold' => 'موقوفة مؤقتًا',
    'closed' => 'مغلقة',
];

?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="page-header d-print-none mb-4">

        <div class="row align-items-center">

            <div class="col">

                <div class="page-pretitle">
                    نظام إدارة مكتب المحاماة
                </div>

                <h2 class="page-title mb-1">
                    لوحة التحكم
                </h2>

                <div class="text-secondary">
                    مرحبًا،
                    <span class="fw-semibold">
                        <?= htmlspecialchars(
                            $user['name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </span>

                    <span class="mx-1">•</span>

                    <?= htmlspecialchars(
                        $roleLabel,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </div>

            </div>

        </div>

    </div>


    <!-- Success Message -->
    <?php if ($success): ?>

        <div
            class="alert alert-success alert-dismissible mb-4"
            role="alert"
        >

            <div class="d-flex align-items-center">

                <div>
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
                        class="icon alert-icon"
                    >
                        <path d="M5 12l5 5l10 -10" />
                    </svg>
                </div>

                <div>
                    <?= htmlspecialchars(
                        $success,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </div>

            </div>

            <a
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="إغلاق"
            ></a>

        </div>

    <?php endif; ?>


    <!-- Statistics -->
    <div class="row row-deck row-cards mb-4">

        <?php if ($user['role'] === 'admin'): ?>

            <!-- Clients -->
            <div class="col-sm-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <span class="avatar avatar-md bg-blue-lt">

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
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                </svg>

                            </span>

                            <div class="ms-3">

                                <div class="subheader">
                                    العملاء
                                </div>

                                <div class="h1 mb-0">
                                    <?= (int) $stats['clients_count'] ?>
                                </div>

                            </div>

                        </div>

                        <div class="text-secondary small mt-3">
                            إجمالي العملاء المسجلين
                        </div>

                    </div>

                </div>

            </div>


            <!-- Cases -->
            <div class="col-sm-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <span class="avatar avatar-md bg-azure-lt">

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
                                    <path d="M5 12l5 5l10 -10" />
                                    <path d="M19 12v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h7" />
                                </svg>

                            </span>

                            <div class="ms-3">

                                <div class="subheader">
                                    القضايا
                                </div>

                                <div class="h1 mb-0">
                                    <?= (int) $stats['cases_count'] ?>
                                </div>

                            </div>

                        </div>

                        <div class="text-secondary small mt-3">
                            إجمالي القضايا المسجلة
                        </div>

                    </div>

                </div>

            </div>


            <!-- Lawyers -->
            <div class="col-sm-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <span class="avatar avatar-md bg-purple-lt">

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
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M3 7l9 -4l9 4l-9 4z" />
                                </svg>

                            </span>

                            <div class="ms-3">

                                <div class="subheader">
                                    المحامون
                                </div>

                                <div class="h1 mb-0">
                                    <?= (int) $stats['lawyers_count'] ?>
                                </div>

                            </div>

                        </div>

                        <div class="text-secondary small mt-3">
                            إجمالي المحامين
                        </div>

                    </div>

                </div>

            </div>


            <!-- Staff -->
            <div class="col-sm-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <span class="avatar avatar-md bg-yellow-lt">

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
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                </svg>

                            </span>

                            <div class="ms-3">

                                <div class="subheader">
                                    الموظفون
                                </div>

                                <div class="h1 mb-0">
                                    <?= (int) $stats['staff_count'] ?>
                                </div>

                            </div>

                        </div>

                        <div class="text-secondary small mt-3">
                            إجمالي الموظفين
                        </div>

                    </div>

                </div>

            </div>


        <?php elseif ($user['role'] === 'staff'): ?>

            <!-- Clients -->
            <div class="col-sm-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <span class="avatar avatar-md bg-blue-lt">

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
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                </svg>

                            </span>

                            <div class="ms-3">

                                <div class="subheader">
                                    العملاء
                                </div>

                                <div class="h1 mb-0">
                                    <?= (int) $stats['clients_count'] ?>
                                </div>

                            </div>

                        </div>

                        <div class="text-secondary small mt-3">
                            إجمالي العملاء المسجلين
                        </div>

                    </div>

                </div>

            </div>


            <!-- Cases -->
            <div class="col-sm-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <span class="avatar avatar-md bg-azure-lt">

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
                                    <path d="M5 12l5 5l10 -10" />
                                    <path d="M19 12v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h7" />
                                </svg>

                            </span>

                            <div class="ms-3">

                                <div class="subheader">
                                    القضايا
                                </div>

                                <div class="h1 mb-0">
                                    <?= (int) $stats['cases_count'] ?>
                                </div>

                            </div>

                        </div>

                        <div class="text-secondary small mt-3">
                            إجمالي القضايا المسجلة
                        </div>

                    </div>

                </div>

            </div>


        <?php elseif ($user['role'] === 'lawyer'): ?>

            <!-- Assigned Cases -->
            <div class="col-sm-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <span class="avatar avatar-md bg-blue-lt">

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
                                    <path d="M5 12l5 5l10 -10" />
                                    <path d="M19 12v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h7" />
                                </svg>

                            </span>

                            <div class="ms-3">

                                <div class="subheader">
                                    القضايا المسندة
                                </div>

                                <div class="h1 mb-0">
                                    <?= (int) $stats['cases_count'] ?>
                                </div>

                            </div>

                        </div>

                        <div class="text-secondary small mt-3">
                            القضايا المسندة إليك
                        </div>

                    </div>

                </div>

            </div>

        <?php endif; ?>

    </div>


    <!-- Case Status -->
    <div class="row row-deck row-cards mb-4">

        <div class="col-12">

            <div class="card">

                <div class="card-header">

                    <div>

                        <h3 class="card-title">
                            حالات القضايا
                        </h3>

                        <div class="text-secondary small mt-1">
                            توزيع القضايا حسب الحالة الحالية
                        </div>

                    </div>

                </div>

                <div class="card-body">

                    <div class="row">

                        <?php foreach ($caseStatusLabels as $status => $label): ?>

                            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">

                                <div class="text-secondary small mb-1">
                                    <?= htmlspecialchars(
                                        $label,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </div>

                                <div class="d-flex align-items-baseline">

                                    <div class="h2 mb-0">
                                        <?= (int) (
                                            $stats['cases_by_status'][$status] ?? 0
                                        ) ?>
                                    </div>

                                    <span class="text-secondary ms-2">
                                        قضية
                                    </span>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Upcoming Events -->
    <div class="row row-deck row-cards">


        <!-- Appointments -->
        <div class="col-lg-6">

            <div class="card h-100">

                <div class="card-header">

                    <h3 class="card-title">
                        المواعيد القادمة
                    </h3>

                    <div class="card-actions">

                        <a
                            href="?route=appointments"
                            class="btn btn-sm btn-ghost-primary"
                        >
                            عرض الكل
                        </a>

                    </div>

                </div>


                <?php if (!empty($stats['upcoming_appointments'])): ?>

                    <div class="list-group list-group-flush">

                        <?php foreach (
                            $stats['upcoming_appointments']
                            as $appointment
                        ): ?>

                            <div class="list-group-item">

                                <div class="row align-items-center">

                                    <div class="col">

                                        <div class="fw-semibold">

                                            <?= htmlspecialchars(
                                                $appointment['title'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </div>

                                        <?php if (
                                            !empty($appointment['client_name'])
                                        ): ?>

                                            <div class="text-secondary small mt-1">

                                                العميل:
                                                <?= htmlspecialchars(
                                                    $appointment['client_name'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>

                                            </div>

                                        <?php endif; ?>

                                    </div>

                                    <div class="col-auto text-end">

                                        <div class="fw-semibold">

                                            <?= htmlspecialchars(
                                                $appointment['appointment_date'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </div>

                                        <div class="text-secondary small">

                                            <?= htmlspecialchars(
                                                $appointment['appointment_time'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <div class="card-body">

                        <div class="empty py-5">

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
                                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                    <path d="M16 3v4" />
                                    <path d="M8 3v4" />
                                    <path d="M4 11h16" />
                                </svg>

                            </div>

                            <p class="empty-title">
                                لا توجد مواعيد قادمة
                            </p>

                            <p class="empty-subtitle text-secondary">
                                لا توجد مواعيد مجدولة حاليًا.
                            </p>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>


        <!-- Hearings -->
        <div class="col-lg-6">

            <div class="card h-100">

                <div class="card-header">

                    <h3 class="card-title">
                        الجلسات القادمة
                    </h3>

                    <div class="card-actions">

                        <a
                            href="?route=cases"
                            class="btn btn-sm btn-ghost-primary"
                        >
                            عرض القضايا
                        </a>

                    </div>

                </div>


                <?php if (!empty($stats['upcoming_hearings'])): ?>

                    <div class="list-group list-group-flush">

                        <?php foreach (
                            $stats['upcoming_hearings']
                            as $hearing
                        ): ?>

                            <div class="list-group-item">

                                <div class="row align-items-center">

                                    <div class="col">

                                        <div class="fw-semibold">

                                            قضية
                                            <?= htmlspecialchars(
                                                $hearing['case_number'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </div>

                                        <div class="text-secondary small mt-1">

                                            العميل:
                                            <?= htmlspecialchars(
                                                $hearing['client_name'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </div>

                                        <div class="text-secondary small mt-1">

                                            المحكمة:
                                            <?= htmlspecialchars(
                                                $hearing['court_name'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </div>

                                    </div>

                                    <div class="col-auto text-end">

                                        <div class="fw-semibold">

                                            <?= htmlspecialchars(
                                                $hearing['hearing_date'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </div>

                                        <div class="text-secondary small">

                                            <?= htmlspecialchars(
                                                $hearing['hearing_time'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <div class="card-body">

                        <div class="empty py-5">

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
                                    <path d="M12 3l8 4v5c0 5 -3.5 8 -8 9c-4.5 -1 -8 -4 -8 -9v-5l8 -4" />
                                    <path d="M12 8v4" />
                                    <path d="M12 16v.01" />
                                </svg>

                            </div>

                            <p class="empty-title">
                                لا توجد جلسات قادمة
                            </p>

                            <p class="empty-subtitle text-secondary">
                                لا توجد جلسات مجدولة حاليًا.
                            </p>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>


<?php require __DIR__ . '/../layouts/footer.php'; ?>