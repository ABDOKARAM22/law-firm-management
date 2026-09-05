<?php

use LawFirmManagement\Core\Session;
use LawFirmManagement\Core\Flash;

$success = Flash::get('success');

$roleLabels = [
    'admin' => 'مدير',
    'lawyer' => 'محامي',
    'staff' => 'موظف',
    'claint' => 'عميل',
];

$statusLabels = [
    'active' => 'نشط',
    'inactive' => 'غير نشط',
];

$statusClasses = [
    'active' => 'bg-green-lt text-green',
    'inactive' => 'bg-red-lt text-red',
];

?>

<?php
$pageTitle = 'المستخدمون';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container-xl">

    <!-- Page Header -->
    <div class="page-header d-print-none mb-3">
        <div class="row align-items-center">

            <div class="col">
                <div class="page-pretitle">
                    إدارة النظام
                </div>

                <h2 class="page-title">
                    المستخدمون
                </h2>

                <div class="text-secondary mt-1">
                    إدارة حسابات المستخدمين وصلاحياتهم وحالاتهم.
                </div>
            </div>

            <?php if (Session::get('user_role') === 'admin'): ?>

                <div class="col-auto ms-auto">
                    <div class="btn-list">

                        <a
                            href="?route=users/create"
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
                                <path d="M12 5v14"></path>
                                <path d="M5 12h14"></path>
                            </svg>

                            إضافة مستخدم
                        </a>

                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>


    <!-- Success Message -->
    <?php if ($success): ?>

        <div
            class="alert alert-success alert-dismissible"
            role="alert"
        >
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
                    <path d="M5 12l5 5l10 -10"></path>
                </svg>

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


    <!-- Users Card -->
    <div class="card">

        <div class="card-header">

            <div>
                <h3 class="card-title">
                    قائمة المستخدمين
                </h3>

                <div class="text-secondary mt-1">
                    إجمالي المستخدمين:
                    <strong><?= count($users) ?></strong>
                </div>
            </div>

        </div>


        <?php if (empty($users)): ?>

            <!-- Empty State -->
            <div class="empty">

                <div class="empty-img">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="80"
                        height="80"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.87"></path>
                    </svg>
                </div>

                <p class="empty-title">
                    لا يوجد مستخدمون
                </p>

                <p class="empty-subtitle text-secondary">
                    لم يتم إضافة أي مستخدمين إلى النظام حتى الآن.
                </p>

                <?php if (Session::get('user_role') === 'admin'): ?>

                    <div class="empty-action">
                        <a
                            href="?route=users/create"
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
                                <path d="M12 5v14"></path>
                                <path d="M5 12h14"></path>
                            </svg>

                            إضافة مستخدم
                        </a>
                    </div>

                <?php endif; ?>

            </div>

        <?php else: ?>

            <!-- Users Table -->
            <div class="table-responsive">

                <table class="table table-vcenter card-table">

                    <thead>
                        <tr>

                            <th>#</th>

                            <th>
                                المستخدم
                            </th>

                            <th>
                                البريد الإلكتروني
                            </th>

                            <th>
                                الدور
                            </th>

                            <th>
                                الحالة
                            </th>

                            <th>
                                تاريخ الإنشاء
                            </th>

                            <?php if (Session::get('user_role') === 'admin'): ?>

                                <th class="w-1">
                                    الإجراءات
                                </th>

                            <?php endif; ?>

                        </tr>
                    </thead>


                    <tbody>

                        <?php foreach ($users as $user): ?>

                            <tr>

                                <!-- ID -->
                                <td class="text-secondary">
                                    <?= (int) $user['id'] ?>
                                </td>


                                <!-- Name -->
                                <td>

                                    <div class="d-flex align-items-center">

                                        <span class="avatar avatar-sm me-2">
                                            <?= htmlspecialchars(
                                                mb_substr(
                                                    $user['name'],
                                                    0,
                                                    1
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </span>

                                        <div>
                                            <div class="fw-bold">
                                                <?= htmlspecialchars(
                                                    $user['name'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </div>
                                        </div>

                                    </div>

                                </td>


                                <!-- Email -->
                                <td>

                                    <span class="text-secondary">
                                        <?= htmlspecialchars(
                                            $user['email'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </span>

                                </td>


                                <!-- Role -->
                                <td>

                                    <span class="badge bg-blue-lt text-blue">

                                        <?= htmlspecialchars(
                                            $roleLabels[$user['role']]
                                                ?? $user['role'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Status -->
                                <td>

                                    <span
                                        class="badge <?= htmlspecialchars(
                                            $statusClasses[$user['status']]
                                                ?? 'bg-secondary-lt text-secondary',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                    >

                                        <span
                                            class="status-dot status-dot-animated"
                                        ></span>

                                        <?= htmlspecialchars(
                                            $statusLabels[$user['status']]
                                                ?? $user['status'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Created At -->
                                <td class="text-secondary">

                                    <?= htmlspecialchars(
                                        $user['created_at'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </td>


                                <!-- Actions -->
                                <?php if (Session::get('user_role') === 'admin'): ?>

                                    <td>

                                        <a
                                            href="?route=users/edit&id=<?= (int) $user['id'] ?>"
                                            class="btn btn-outline-primary btn-sm"
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

                                <?php endif; ?>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>


    <!-- Back -->
    <div class="mt-3">

        <a
            href="?route=dashboard"
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
                <path d="M9 14l-4 -4l4 -4"></path>
                <path d="M5 10h11a4 4 0 1 1 0 8h-1"></path>
            </svg>

            العودة للوحة التحكم
        </a>

    </div>

</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>