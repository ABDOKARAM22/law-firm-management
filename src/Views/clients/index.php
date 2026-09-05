<?php

use LawFirmManagement\Core\Session;
use LawFirmManagement\Core\Flash;

$success = Flash::get('success');

$statusLabels = [
    'active' => 'نشط',
    'inactive' => 'غير نشط',
];

$statusBadgeClasses = [
    'active' => 'bg-green-lt text-green',
    'inactive' => 'bg-secondary-lt text-secondary',
];

$pageTitle = 'العملاء';

?>

<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container-xl">

    <!-- Page Header -->
    <div class="page-header d-print-none mb-4">

        <div class="row align-items-center">

            <div class="col">

                <div class="page-pretitle">
                    إدارة العملاء
                </div>

                <h2 class="page-title">
                    العملاء
                </h2>

            </div>

            <?php if (Session::get('user_role') === 'admin'): ?>

                <div class="col-auto ms-auto">

                    <div class="btn-list">

                        <a
                            href="?route=clients/create"
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

                            إضافة عميل

                        </a>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>


    <!-- Success Message -->
    <?php if ($success): ?>

        <div
            class="alert alert-success alert-dismissible mb-4"
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

        </div>

    <?php endif; ?>


    <!-- Clients Card -->
    <div class="card">

        <div class="card-header">

            <div>

                <h3 class="card-title">
                    قائمة العملاء
                </h3>

                <div class="text-secondary small mt-1">
                    إجمالي العملاء:
                    <?= count($clients) ?>
                </div>

            </div>

        </div>


        <?php if (empty($clients)): ?>

            <!-- Empty State -->
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
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                        </svg>

                    </div>

                    <p class="empty-title">
                        لا يوجد عملاء
                    </p>

                    <p class="empty-subtitle text-secondary">
                        لم تتم إضافة أي عملاء حتى الآن.
                    </p>

                    <?php if (Session::get('user_role') === 'admin'): ?>

                        <div class="empty-action">

                            <a
                                href="?route=clients/create"
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

                                إضافة أول عميل

                            </a>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        <?php else: ?>

            <!-- Clients Table -->
            <div class="table-responsive">

                <table class="table table-vcenter card-table">

                    <thead>

                        <tr>

                            <th>الاسم</th>

                            <th>الرقم القومي</th>

                            <th>الهاتف</th>

                            <th>Email</th>

                            <th>الحالة</th>

                            <?php if (Session::get('user_role') === 'admin'): ?>

                                <th class="w-1">
                                    إجراء
                                </th>

                            <?php endif; ?>

                        </tr>

                    </thead>


                    <tbody>

                    <?php foreach ($clients as $client): ?>

                        <tr>

                            <!-- Name -->
                            <td>

                                <div class="fw-semibold">

                                    <?= htmlspecialchars(
                                        $client['name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </div>

                            </td>


                            <!-- National ID -->
                            <td>

                                <span class="text-secondary">

                                    <?= htmlspecialchars(
                                        $client['national_id'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </span>

                            </td>


                            <!-- Phone -->
                            <td>

                                <?= htmlspecialchars(
                                    $client['phone'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <!-- Email -->
                            <td>

                                <?php if (!empty($client['email'])): ?>

                                    <?= htmlspecialchars(
                                        $client['email'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                <?php else: ?>

                                    <span class="text-secondary">
                                        —
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- Status -->
                            <td>

                                <span
                                    class="badge <?= $statusBadgeClasses[$client['status']] ?? 'bg-secondary-lt text-secondary' ?>"
                                >
                                    <?= htmlspecialchars(
                                        $statusLabels[$client['status']]
                                            ?? $client['status'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </span>

                            </td>


                            <!-- Actions -->
                            <?php if (Session::get('user_role') === 'admin'): ?>

                                <td>

                                    <a
                                        href="?route=clients/edit&id=<?= (int) $client['id'] ?>"
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

                            <?php endif; ?>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>