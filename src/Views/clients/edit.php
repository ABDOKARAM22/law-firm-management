<?php

use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\Csrf;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

$name = $old['name'] ?? $client['name'];
$nationalId = $old['national_id'] ?? $client['national_id'];
$phone = $old['phone'] ?? $client['phone'];
$email = $old['email'] ?? ($client['email'] ?? '');
$address = $old['address'] ?? ($client['address'] ?? '');
$status = $old['status'] ?? $client['status'];

$pageTitle = 'تعديل العميل';

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
                    تعديل العميل
                </h2>

            </div>

        </div>

    </div>


    <!-- Client Form -->
    <form
        method="POST"
        action="?route=clients/edit"
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

        <input
            type="hidden"
            name="id"
            value="<?= (int) $client['id'] ?>"
        >


        <!-- Personal Information -->
        <div class="card mb-4">

            <div class="card-header">

                <div>

                    <h3 class="card-title">
                        البيانات الأساسية
                    </h3>

                    <div class="text-secondary small mt-1">
                        البيانات الشخصية الأساسية للعميل
                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="row g-3">

                    <!-- Name -->
                    <div class="col-md-6">

                        <label
                            class="form-label required"
                            for="name"
                        >
                            الاسم
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control<?= isset($errors['name']) ? ' is-invalid' : '' ?>"
                            value="<?= htmlspecialchars(
                                $name,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
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


                    <!-- National ID -->
                    <div class="col-md-6">

                        <label
                            class="form-label required"
                            for="national_id"
                        >
                            الرقم القومي
                        </label>

                        <input
                            type="text"
                            id="national_id"
                            name="national_id"
                            class="form-control<?= isset($errors['national_id']) ? ' is-invalid' : '' ?>"
                            value="<?= htmlspecialchars(
                                $nationalId,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            required
                        >

                        <?php if (isset($errors['national_id'])): ?>

                            <div class="invalid-feedback">

                                <?= htmlspecialchars(
                                    $errors['national_id'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </div>

                        <?php endif; ?>

                    </div>


                    <!-- Phone -->
                    <div class="col-md-6">

                        <label
                            class="form-label required"
                            for="phone"
                        >
                            رقم الهاتف
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="form-control<?= isset($errors['phone']) ? ' is-invalid' : '' ?>"
                            value="<?= htmlspecialchars(
                                $phone,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            required
                        >

                        <?php if (isset($errors['phone'])): ?>

                            <div class="invalid-feedback">

                                <?= htmlspecialchars(
                                    $errors['phone'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </div>

                        <?php endif; ?>

                    </div>


                    <!-- Email -->
                    <div class="col-md-6">

                        <label
                            class="form-label"
                            for="email"
                        >
                            البريد الإلكتروني
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>"
                            value="<?= htmlspecialchars(
                                $email,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
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

                </div>

            </div>

        </div>


        <!-- Contact Information -->
        <div class="card mb-4">

            <div class="card-header">

                <div>

                    <h3 class="card-title">
                        بيانات التواصل
                    </h3>

                    <div class="text-secondary small mt-1">
                        عنوان العميل وبيانات التواصل الإضافية
                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="row g-3">

                    <!-- Address -->
                    <div class="col-12">

                        <label
                            class="form-label"
                            for="address"
                        >
                            العنوان
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            class="form-control<?= isset($errors['address']) ? ' is-invalid' : '' ?>"
                            rows="4"
                        ><?= htmlspecialchars(
                            $address,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?></textarea>

                        <?php if (isset($errors['address'])): ?>

                            <div class="invalid-feedback">

                                <?= htmlspecialchars(
                                    $errors['address'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>


        <!-- Client Status -->
        <div class="card mb-4">

            <div class="card-header">

                <div>

                    <h3 class="card-title">
                        حالة العميل
                    </h3>

                </div>

            </div>


            <div class="card-body">

                <div class="row g-3">

                    <!-- Status -->
                    <div class="col-md-6">

                        <label
                            class="form-label required"
                            for="status"
                        >
                            الحالة
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select<?= isset($errors['status']) ? ' is-invalid' : '' ?>"
                            required
                        >

                            <option
                                value="active"
                                <?= $status === 'active'
                                    ? 'selected'
                                    : '' ?>
                            >
                                نشط
                            </option>

                            <option
                                value="inactive"
                                <?= $status === 'inactive'
                                    ? 'selected'
                                    : '' ?>
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
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>

                        حفظ التعديلات

                    </button>


                    <a
                        href="?route=clients"
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
                            <path d="M5 10h8a4 4 0 1 1 0 8h-1"></path>
                        </svg>

                        العودة للعملاء

                    </a>

                </div>

            </div>

        </div>

    </form>

</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>