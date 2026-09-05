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

$hearingStatusLabels = [
    'scheduled' => 'مجدولة',
    'completed' => 'مكتملة',
    'cancelled' => 'ملغاة',
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

                <h2 class="page-title">
                    لوحة التحكم
                </h2>

                <div class="text-secondary mt-1">
                    مرحبًا، <?= htmlspecialchars(
                        $user['name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

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

            <div>
                <?= htmlspecialchars(
                    $success,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
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

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div>
                                <div class="subheader">
                                    العملاء
                                </div>

                                <div class="h1 mb-0">
                                    <?= (int) $stats['clients_count'] ?>
                                </div>
                            </div>

                        </div>

                        <div class="text-secondary mt-2">
                            إجمالي العملاء
                        </div>

                    </div>

                </div>

            </div>


            <!-- Cases -->
            <div class="col-sm-6 col-lg-3">

                <div class="card">

                    <div class="card-body">

                        <div class="subheader">
                            القضايا
                        </div>

                        <div class="h1 mb-0">
                            <?= (int) $stats['cases_count'] ?>
                        </div>

                        <div class="text-secondary mt-2">
                            إجمالي القضايا
                        </div>

                    </div>

                </div>

            </div>


            <!-- Lawyers -->
            <div class="col-sm-6 col-lg-3">

                <div class="card">

                    <div class="card-body">

                        <div class="subheader">
                            المحامون
                        </div>

                        <div class="h1 mb-0">
                            <?= (int) $stats['lawyers_count'] ?>
                        </div>

                        <div class="text-secondary mt-2">
                            إجمالي المحامين
                        </div>

                    </div>

                </div>

            </div>


            <!-- Staff -->
            <div class="col-sm-6 col-lg-3">

                <div class="card">

                    <div class="card-body">

                        <div class="subheader">
                            الموظفون
                        </div>

                        <div class="h1 mb-0">
                            <?= (int) $stats['staff_count'] ?>
                        </div>

                        <div class="text-secondary mt-2">
                            إجمالي الموظفين
                        </div>

                    </div>

                </div>

            </div>


        <?php elseif ($user['role'] === 'staff'): ?>

            <!-- Clients -->
            <div class="col-sm-6 col-lg-3">

                <div class="card">

                    <div class="card-body">

                        <div class="subheader">
                            العملاء
                        </div>

                        <div class="h1 mb-0">
                            <?= (int) $stats['clients_count'] ?>
                        </div>

                        <div class="text-secondary mt-2">
                            إجمالي العملاء
                        </div>

                    </div>

                </div>

            </div>


            <!-- Cases -->
            <div class="col-sm-6 col-lg-3">

                <div class="card">

                    <div class="card-body">

                        <div class="subheader">
                            القضايا
                        </div>

                        <div class="h1 mb-0">
                            <?= (int) $stats['cases_count'] ?>
                        </div>

                        <div class="text-secondary mt-2">
                            إجمالي القضايا
                        </div>

                    </div>

                </div>

            </div>


        <?php elseif ($user['role'] === 'lawyer'): ?>

            <!-- Assigned Cases -->
            <div class="col-sm-6 col-lg-3">

                <div class="card">

                    <div class="card-body">

                        <div class="subheader">
                            القضايا المسندة
                        </div>

                        <div class="h1 mb-0">
                            <?= (int) $stats['cases_count'] ?>
                        </div>

                        <div class="text-secondary mt-2">
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

                    <h3 class="card-title">
                        حالات القضايا
                    </h3>

                </div>

                <div class="card-body">

                    <div class="row">

                        <?php foreach ($caseStatusLabels as $status => $label): ?>

                            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">

                                <div class="d-flex align-items-center">

                                    <div>

                                        <div class="text-secondary">
                                            <?= htmlspecialchars(
                                                $label,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </div>

                                        <div class="h2 mb-0">

                                            <?= (int) (
                                                $stats['cases_by_status'][$status] ?? 0
                                            ) ?>

                                        </div>

                                    </div>

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

                        <a href="?route=appointments">
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

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <div class="fw-bold">

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

                                    <div class="text-end">

                                        <div class="fw-bold">

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

                        <div class="empty">

                            <div class="empty-icon">
                                📅
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

                        <a href="?route=cases">
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

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <div class="fw-bold">

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

                                    <div class="text-end">

                                        <div class="fw-bold">

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

                        <div class="empty">

                            <div class="empty-icon">
                                ⚖️
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