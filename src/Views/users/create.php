<?php

use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\Csrf;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

?>

<?php
$pageTitle = 'إضافة مستخدم';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container-xl">

    <!-- Page Header -->
    <div class="page-header d-print-none mb-3">
        <div class="row align-items-center">

            <div class="col">

                <div class="page-pretitle">
                    إدارة المستخدمين
                </div>

                <h2 class="page-title">
                    إضافة مستخدم
                </h2>

                <div class="text-secondary mt-1">
                    إضافة حساب مستخدم جديد إلى النظام وتحديد دوره وحالته.
                </div>

            </div>

            <div class="col-auto ms-auto">

                <a
                    href="?route=users"
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

                    العودة للمستخدمين

                </a>

            </div>

        </div>
    </div>


    <!-- General Error -->
    <?php if ($error = Flash::get('error')): ?>

        <div
            class="alert alert-danger"
            role="alert"
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
                class="icon alert-icon"
            >
                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                <path d="M12 8v4"></path>
                <path d="M12 16h.01"></path>
            </svg>

            <?= htmlspecialchars(
                $error,
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </div>

    <?php endif; ?>


    <form
        method="POST"
        action="?route=users/create"
    >

        <input
            type="hidden"
            name="_token"
            value="<?= htmlspecialchars(
                Csrf::token(),
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >


        <!-- Basic Information -->
        <div class="card mb-3">

            <div class="card-header">

                <div>

                    <h3 class="card-title">
                        البيانات الأساسية
                    </h3>

                    <div class="text-secondary mt-1">
                        بيانات الدخول الأساسية للمستخدم.
                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="row g-3">

                    <!-- Name -->
                    <div class="col-md-6">

                        <label
                            for="name"
                            class="form-label"
                        >
                            الاسم
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars(
                                $old['name'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            placeholder="أدخل اسم المستخدم"
                            required
                        >

                        <?php if (isset($errors['name'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars(
                                    $errors['name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        <?php endif; ?>

                    </div>


                    <!-- Email -->
                    <div class="col-md-6">

                        <label
                            for="email"
                            class="form-label"
                        >
                            البريد الإلكتروني
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars(
                                $old['email'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            placeholder="example@email.com"
                            required
                        >

                        <?php if (isset($errors['email'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars(
                                    $errors['email'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        <?php endif; ?>

                    </div>


                    <!-- Password -->
                    <div class="col-md-6">

                        <label
                            for="password"
                            class="form-label"
                        >
                            كلمة المرور
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                            placeholder="أدخل كلمة المرور"
                            required
                        >

                        <?php if (isset($errors['password'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars(
                                    $errors['password'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>


        <!-- Role & Status -->
        <div class="card mb-3">

            <div class="card-header">

                <div>

                    <h3 class="card-title">
                        الصلاحيات والحالة
                    </h3>

                    <div class="text-secondary mt-1">
                        تحديد دور المستخدم وحالة حسابه.
                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="row g-3">

                    <!-- Role -->
                    <div class="col-md-6">

                        <label
                            for="role"
                            class="form-label"
                        >
                            الدور
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            id="role"
                            name="role"
                            class="form-select <?= isset($errors['role']) ? 'is-invalid' : '' ?>"
                            required
                        >

                            <option value="" disabled>
                                اختر الدور
                            </option>

                            <option
                                value="admin"
                                <?= ($old['role'] ?? '') === 'admin' ? 'selected' : '' ?>
                            >
                                مدير
                            </option>

                            <option
                                value="lawyer"
                                <?= ($old['role'] ?? '') === 'lawyer' ? 'selected' : '' ?>
                            >
                                محامي
                            </option>

                            <option
                                value="staff"
                                <?= ($old['role'] ?? '') === 'staff' ? 'selected' : '' ?>
                            >
                                موظف
                            </option>

                        </select>

                        <?php if (isset($errors['role'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars(
                                    $errors['role'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        <?php endif; ?>

                    </div>


                    <!-- Status -->
                    <div class="col-md-6">

                        <label
                            for="status"
                            class="form-label"
                        >
                            الحالة
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>"
                            required
                        >

                            <option value="" disabled>
                                اختر الحالة
                            </option>

                            <option
                                value="active"
                                <?= ($old['status'] ?? '') === 'active' ? 'selected' : '' ?>
                            >
                                نشط
                            </option>

                            <option
                                value="inactive"
                                <?= ($old['status'] ?? '') === 'inactive' ? 'selected' : '' ?>
                            >
                                غير نشط
                            </option>

                        </select>

                        <?php if (isset($errors['status'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars(
                                    $errors['status'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>


        <!-- Actions -->
        <div class="card">

            <div class="card-body">

                <div class="d-flex flex-wrap gap-2">

                    <button
                        type="submit"
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

                        إضافة المستخدم

                    </button>


                    <a
                        href="?route=users"
                        class="btn btn-outline-secondary"
                    >
                        إلغاء
                    </a>

                </div>

            </div>

        </div>

    </form>

</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>