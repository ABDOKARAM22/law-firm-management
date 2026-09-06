<?php

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;

$error = Flash::get('error');
$success = Flash::get('success');

?>

<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        تسجيل الدخول | مكتب المحاماة
    </title>

    <!-- Tabler RTL -->
    <link
        rel="stylesheet"
        href="assets/tabler/dist/css/tabler.rtl.min.css"
    >

    <!-- Application CSS -->
    <link
        rel="stylesheet"
        href="assets/css/app.css"
    >

</head>

<body>

<div class="page page-center">

    <div class="container container-tight py-4">

        <!-- Brand -->
        <div class="text-center mb-4">

            <a
                href="#"
                class="navbar-brand navbar-brand-autodark"
            >

                <!-- <span class="law-brand-icon">
                    ⚖️
                </span> -->

                <span class="fw-bold">
                    مكتب المحاماة
                </span>

            </a>

        </div>

        <!-- Login Card -->
        <div class="card card-md">

            <div class="card-body">

                <h2 class="h2 text-center mb-4">
                    تسجيل الدخول
                </h2>

                <!-- Error Message -->
                <?php if ($error): ?>

                    <div
                        class="alert alert-danger"
                        role="alert"
                    >

                        <div class="d-flex">

                            <div>
                                <i class="ti ti-alert-circle me-2"></i>
                            </div>

                            <div>
                                <?= htmlspecialchars(
                                    $error,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        </div>

                    </div>

                <?php endif; ?>

                <!-- Success Message -->
                <?php if ($success): ?>

                    <div
                        class="alert alert-success"
                        role="alert"
                    >

                        <div class="d-flex">

                            <div>
                                <i class="ti ti-check me-2"></i>
                            </div>

                            <div>
                                <?= htmlspecialchars(
                                    $success,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        </div>

                    </div>

                <?php endif; ?>

                <form
                    method="POST"
                    action="?route=login"
                >

                    <!-- CSRF -->
                    <input
                        type="hidden"
                        name="_token"
                        value="<?= htmlspecialchars(
                            Csrf::token(),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                    <!-- Email -->
                    <div class="mb-3">

                        <label
                            for="email"
                            class="form-label"
                        >
                            البريد الإلكتروني
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="البريد الإلكتروني"
                            autocomplete="email"
                            required
                        >

                    </div>

                    <!-- Password -->
                    <div class="mb-3">

                        <label
                            for="password"
                            class="form-label"
                        >
                            كلمة المرور
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="كلمة المرور"
                            autocomplete="current-password"
                            required
                        >

                    </div>

                    <!-- Submit -->
                    <div class="form-footer">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >

                            <i class="ti ti-login me-1"></i>

                            تسجيل الدخول

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- Footer -->
        <div class="text-center text-secondary mt-3">

            نظام إدارة مكتب المحاماة

        </div>

    </div>

</div>

<!-- Tabler JS -->
<script src="assets/tabler/dist/js/tabler.min.js"></script>

</body>

</html>