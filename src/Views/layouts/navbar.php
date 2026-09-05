<?php

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Session;

$userName = Session::get('user_name');
$userRole = Session::get('user_role');

$roleLabels = [
    'admin'  => 'مدير',
    'lawyer' => 'محامي',
    'staff'  => 'موظف',
];

$roleLabel = $roleLabels[$userRole] ?? 'مستخدم';

?>

<header class="navbar navbar-expand-md d-print-none">

    <div class="container-fluid">

        <!-- Mobile Menu Button -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar-menu"
            aria-controls="navbar-menu"
            aria-expanded="false"
            aria-label="فتح القائمة"
        >
            <span class="navbar-toggler-icon"></span>
        </button>


        <!-- Page Title -->
        <div class="navbar-nav">

            <div class="nav-item">

                <span class="nav-link fw-bold">
                    <?= htmlspecialchars($pageTitle ?? 'لوحة التحكم') ?>
                </span>

            </div>

        </div>


        <!-- User Menu -->
        <div class="navbar-nav flex-row order-md-last">

            <!-- User Information -->
            <div class="nav-item d-none d-md-flex align-items-center">

                <div class="nav-link">

                    <div class="d-flex align-items-center">

                        <!-- User Avatar -->
                        <span class="avatar avatar-sm me-2">
                            <?= htmlspecialchars(mb_substr($userName ?? 'م', 0, 1)) ?>
                        </span>


                        <!-- User Name + Role -->
                        <div class="lh-sm">

                            <div class="fw-semibold">
                                <?= htmlspecialchars($userName ?? '') ?>
                            </div>

                            <div class="text-secondary small">
                                <?= htmlspecialchars($roleLabel) ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Logout -->
            <div class="nav-item">

                <form
                    method="POST"
                    action="?route=logout"
                    class="m-0"
                >

                    <input
                        type="hidden"
                        name="_token"
                        value="<?= htmlspecialchars(Csrf::token()) ?>"
                    >

                    <button
                        type="submit"
                        class="btn btn-ghost-danger"
                    >
                        <i class="ti ti-logout me-1"></i>
                        تسجيل الخروج
                    </button>

                </form>

            </div>

        </div>

    </div>

</header>