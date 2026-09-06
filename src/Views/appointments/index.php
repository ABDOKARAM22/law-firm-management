<?php

use LawFirmManagement\Core\Flash;

$success = Flash::get('success');

$statusLabels = [
    'scheduled' => 'مجدول',
    'completed' => 'مكتمل',
    'cancelled' => 'ملغي',
];

?>

<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-wrapper">

    <div class="container-xl py-4">

        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">

            <div>
                <h2 class="page-title mb-1">
                    المواعيد
                </h2>

                <p class="text-secondary mb-0">
                    إدارة ومتابعة مواعيد المكتب
                </p>
            </div>

            <div>
                <a
                    href="?route=appointments/create"
                    class="btn btn-primary"
                >
                    <i class="ti ti-plus me-1"></i>
                    إضافة موعد
                </a>
            </div>

        </div>


        <!-- Success Message -->
        <?php if ($success): ?>

            <div
                class="alert alert-success alert-dismissible mb-4"
                role="alert"
            >
                <div class="d-flex">

                    <i class="ti ti-check me-2"></i>

                    <div>
                        <?= htmlspecialchars($success) ?>
                    </div>

                </div>

                <a
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="close"
                ></a>
            </div>

        <?php endif; ?>


        <!-- Appointments Card -->
        <div class="card">

            <div class="card-header">

                <div class="d-flex align-items-center">

                    <span class="avatar avatar-sm bg-primary-lt me-2">
                        <i class="ti ti-calendar-event"></i>
                    </span>

                    <div>
                        <h3 class="card-title mb-0">
                            قائمة المواعيد
                        </h3>

                        <div class="text-secondary small">
                            جميع المواعيد المسجلة في النظام
                        </div>
                    </div>

                </div>

            </div>


            <div class="card-body p-0">

                <?php if (empty($appointments)): ?>

                    <!-- Empty State -->
                    <div class="empty py-5">

                        <div class="empty-icon">
                            <i class="ti ti-calendar-off"></i>
                        </div>

                        <p class="empty-title">
                            لا توجد مواعيد
                        </p>

                        <p class="empty-subtitle text-secondary">
                            لم يتم تسجيل أي مواعيد حتى الآن.
                        </p>

                        <div class="empty-action">

                            <a
                                href="?route=appointments/create"
                                class="btn btn-primary"
                            >
                                <i class="ti ti-plus me-1"></i>
                                إضافة موعد
                            </a>

                        </div>

                    </div>

                <?php else: ?>

                    <div class="table-responsive">

                        <table class="table table-vcenter card-table">

                            <thead>
                                <tr>

                                    <th>العميل</th>

                                    <th>المسؤول</th>

                                    <th>التاريخ</th>

                                    <th>الوقت</th>

                                    <th>العنوان</th>

                                    <th>النوع</th>

                                    <th>الحالة</th>

                                    <th class="text-center">
                                        الإجراءات
                                    </th>

                                </tr>
                            </thead>


                            <tbody>

                            <?php foreach ($appointments as $appointment): ?>

                                <tr>

                                    <!-- Client -->
                                    <td>

                                        <div class="d-flex align-items-center">

                                            <span class="avatar avatar-sm bg-secondary-lt me-2">
                                                <i class="ti ti-user"></i>
                                            </span>

                                            <div>

                                                <?=
                                                    $appointment['client_name']
                                                        ? htmlspecialchars($appointment['client_name'])
                                                        : 'بدون عميل'
                                                ?>

                                            </div>

                                        </div>

                                    </td>


                                    <!-- Assigned User -->
                                    <td>

                                        <div class="d-flex align-items-center">

                                            <span class="avatar avatar-sm bg-blue-lt me-2">
                                                <i class="ti ti-user-check"></i>
                                            </span>

                                            <span>
                                                <?= htmlspecialchars($appointment['assigned_user_name']) ?>
                                            </span>

                                        </div>

                                    </td>


                                    <!-- Date -->
                                    <td>

                                        <div class="d-flex align-items-center text-secondary">

                                            <i class="ti ti-calendar me-2"></i>

                                            <span>
                                                <?= htmlspecialchars($appointment['appointment_date']) ?>
                                            </span>

                                        </div>

                                    </td>


                                    <!-- Time -->
                                    <td>

                                        <div class="d-flex align-items-center text-secondary">

                                            <i class="ti ti-clock me-2"></i>

                                            <span>
                                                <?= htmlspecialchars($appointment['appointment_time']) ?>
                                            </span>

                                        </div>

                                    </td>


                                    <!-- Title -->
                                    <td>

                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($appointment['title']) ?>
                                        </div>

                                    </td>


                                    <!-- Type -->
                                    <td>

                                        <span class="text-secondary">
                                            <?= htmlspecialchars($appointment['type']) ?>
                                        </span>

                                    </td>


                                    <!-- Status -->
                                    <td>

                                        <?php

                                        $status = $appointment['status'];

                                        $statusLabel = $statusLabels[$status] ?? $status;

                                        $statusClass = match ($status) {
                                            'scheduled' => 'bg-blue-lt text-blue',
                                            'completed' => 'bg-green-lt text-green',
                                            'cancelled' => 'bg-red-lt text-red',
                                            default => 'bg-secondary-lt text-secondary',
                                        };

                                        ?>

                                        <span class="badge <?= $statusClass ?>">

                                            <?= htmlspecialchars($statusLabel) ?>

                                        </span>

                                    </td>


                                    <!-- Actions -->
                                    <td class="text-center">

                                        <a
                                            href="?route=appointments/edit&id=<?= (int) $appointment['id'] ?>"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            <i class="ti ti-edit me-1"></i>
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

        </div>

    </div>

</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>