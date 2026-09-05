<?php

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

/*
|-------------------------------------------------------------------------- 
| Values
|-------------------------------------------------------------------------- 
| Use old values after validation failure.
| Otherwise use the current case values.
*/

$caseNumber = $old['case_number'] ?? $case['case_number'];
$title = $old['title'] ?? $case['title'];
$clientId = $old['client_id'] ?? $case['client_id'];
$assignedLawyerId = $old['assigned_lawyer_id'] ?? $case['assigned_lawyer_id'];
$caseTypeId = $old['case_type_id'] ?? $case['case_type_id'];
$courtName = $old['court_name'] ?? $case['court_name'];
$courtNumber = $old['court_number'] ?? $case['court_number'];
$status = $old['status'] ?? $case['status'];
$description = $old['description'] ?? $case['description'];
$filingDate = $old['filing_date'] ?? $case['filing_date'];

$pageTitle = 'تعديل القضية';

require __DIR__ . '/../layouts/header.php';
?>


<div class="container-xl">


    <!-- Page Header -->

    <div class="page-header d-print-none mb-4">

        <div class="row align-items-center">

            <div class="col">

                <div class="page-pretitle">
                    القضايا
                </div>

                <h2 class="page-title">
                    تعديل القضية
                </h2>

                <div class="text-secondary mt-1">
                    قم بتحديث بيانات القضية ثم احفظ التعديلات.
                </div>

            </div>


            <div class="col-auto ms-auto d-print-none">

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
                        class="icon icon-1"
                    >
                        <path d="M5 12l14 0" />
                        <path d="M5 12l6 6" />
                        <path d="M5 12l6 -6" />
                    </svg>

                    العودة للقضايا

                </a>

            </div>

        </div>

    </div>


    <form
        method="POST"
        action="?route=cases/edit&id=<?= (int) $case['id'] ?>"
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


        <div class="row row-cards">


            <!-- Main Form -->

            <div class="col-lg-8">


                <!-- Case Information -->

                <div class="card mb-3">

                    <div class="card-header">

                        <div>

                            <h3 class="card-title">
                                بيانات القضية
                            </h3>

                            <div class="text-secondary small mt-1">
                                البيانات الأساسية الخاصة بالقضية.
                            </div>

                        </div>

                    </div>


                    <div class="card-body">

                        <div class="row g-3">


                            <!-- Case Number -->

                            <div class="col-md-6">

                                <label
                                    class="form-label required"
                                    for="case_number"
                                >
                                    رقم القضية
                                </label>

                                <input
                                    type="text"
                                    id="case_number"
                                    name="case_number"
                                    class="form-control<?= isset($errors['case_number']) ? ' is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars(
                                        $caseNumber,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                    autocomplete="off"
                                >

                                <?php if (isset($errors['case_number'])): ?>

                                    <div class="invalid-feedback">
                                        <?= htmlspecialchars(
                                            $errors['case_number'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </div>

                                <?php endif; ?>

                            </div>


                            <!-- Title -->

                            <div class="col-md-6">

                                <label
                                    class="form-label required"
                                    for="title"
                                >
                                    عنوان القضية
                                </label>

                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    class="form-control<?= isset($errors['title']) ? ' is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars(
                                        $title,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                >

                                <?php if (isset($errors['title'])): ?>

                                    <div class="invalid-feedback">
                                        <?= htmlspecialchars(
                                            $errors['title'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </div>

                                <?php endif; ?>

                            </div>


                            <!-- Client -->

                            <div class="col-md-6">

                                <label
                                    class="form-label required"
                                    for="client_id"
                                >
                                    العميل
                                </label>

                                <select
                                    id="client_id"
                                    name="client_id"
                                    class="form-select<?= isset($errors['client_id']) ? ' is-invalid' : '' ?>"
                                >

                                    <option value="">
                                        اختر العميل
                                    </option>

                                    <?php foreach ($clients as $client): ?>

                                        <option
                                            value="<?= (int) $client['id'] ?>"
                                            <?= (string) $clientId === (string) $client['id']
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            <?= htmlspecialchars(
                                                $client['name'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                                <?php if (isset($errors['client_id'])): ?>

                                    <div class="invalid-feedback">
                                        <?= htmlspecialchars(
                                            $errors['client_id'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </div>

                                <?php endif; ?>

                            </div>

                            <!-- Lawyer -->

                            <div class="col-md-6">

                                <label
                                    class="form-label required"
                                    for="assigned_lawyer_id"
                                >
                                    المحامي المسؤول
                                </label>

                                <?php if ($user['role'] === 'lawyer'): ?>

                                    <div class="form-control bg-light">
                                        <?= htmlspecialchars(
                                            $case['lawyer_name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </div>

                                <?php else: ?>

                                    <select
                                        id="assigned_lawyer_id"
                                        name="assigned_lawyer_id"
                                        class="form-select<?= isset($errors['assigned_lawyer_id']) ? ' is-invalid' : '' ?>"
                                    >

                                        <option value="">
                                            اختر المحامي
                                        </option>

                                        <?php foreach ($lawyers as $lawyer): ?>

                                            <option
                                                value="<?= (int) $lawyer['id'] ?>"
                                                <?= (string) $assignedLawyerId === (string) $lawyer['id']
                                                    ? 'selected'
                                                    : '' ?>
                                            >
                                                <?= htmlspecialchars(
                                                    $lawyer['name'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                    <?php if (isset($errors['assigned_lawyer_id'])): ?>

                                        <div class="invalid-feedback">
                                            <?= htmlspecialchars(
                                                $errors['assigned_lawyer_id'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </div>

                                    <?php endif; ?>

                                <?php endif; ?>

                            </div>

                            <!-- Case Type -->

                            <div class="col-md-6">

                                <label
                                    class="form-label required"
                                    for="case_type_id"
                                >
                                    نوع القضية
                                </label>

                                <select
                                    id="case_type_id"
                                    name="case_type_id"
                                    class="form-select<?= isset($errors['case_type_id']) ? ' is-invalid' : '' ?>"
                                >

                                    <option value="">
                                        اختر نوع القضية
                                    </option>

                                    <?php foreach ($caseTypes as $caseType): ?>

                                        <option
                                            value="<?= (int) $caseType['id'] ?>"
                                            <?= (string) $caseTypeId === (string) $caseType['id']
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            <?= htmlspecialchars(
                                                $caseType['name'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                                <?php if (isset($errors['case_type_id'])): ?>

                                    <div class="invalid-feedback">
                                        <?= htmlspecialchars(
                                            $errors['case_type_id'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </div>

                                <?php endif; ?>

                            </div>


                            <!-- Filing Date -->

                            <div class="col-md-6">

                                <label
                                    class="form-label"
                                    for="filing_date"
                                >
                                    تاريخ القيد
                                </label>

                                <input
                                    type="date"
                                    id="filing_date"
                                    name="filing_date"
                                    class="form-control<?= isset($errors['filing_date']) ? ' is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars(
                                        $filingDate ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                >

                                <?php if (isset($errors['filing_date'])): ?>

                                    <div class="invalid-feedback">
                                        <?= htmlspecialchars(
                                            $errors['filing_date'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </div>

                                <?php endif; ?>

                            </div>


                        </div>

                    </div>

                </div>


                <!-- Court Information -->

                <div class="card mb-3">

                    <div class="card-header">

                        <div>

                            <h3 class="card-title">
                                بيانات المحكمة
                            </h3>

                            <div class="text-secondary small mt-1">
                                معلومات المحكمة المرتبطة بالقضية.
                            </div>

                        </div>

                    </div>


                    <div class="card-body">

                        <div class="row g-3">


                            <!-- Court Name -->

                            <div class="col-md-6">

                                <label
                                    class="form-label required"
                                    for="court_name"
                                >
                                    اسم المحكمة
                                </label>

                                <input
                                    type="text"
                                    id="court_name"
                                    name="court_name"
                                    class="form-control<?= isset($errors['court_name']) ? ' is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars(
                                        $courtName,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                >

                                <?php if (isset($errors['court_name'])): ?>

                                    <div class="invalid-feedback">
                                        <?= htmlspecialchars(
                                            $errors['court_name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </div>

                                <?php endif; ?>

                            </div>


                            <!-- Court Number -->

                            <div class="col-md-6">

                                <label
                                    class="form-label"
                                    for="court_number"
                                >
                                    رقم المحكمة
                                </label>

                                <input
                                    type="text"
                                    id="court_number"
                                    name="court_number"
                                    class="form-control<?= isset($errors['court_number']) ? ' is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars(
                                        $courtNumber ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                >

                                <?php if (isset($errors['court_number'])): ?>

                                    <div class="invalid-feedback">
                                        <?= htmlspecialchars(
                                            $errors['court_number'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </div>

                                <?php endif; ?>

                            </div>


                        </div>

                    </div>

                </div>


                <!-- Description -->

                <div class="card">

                    <div class="card-header">

                        <div>

                            <h3 class="card-title">
                                وصف القضية
                            </h3>

                            <div class="text-secondary small mt-1">
                                التفاصيل والملاحظات المرتبطة بالقضية.
                            </div>

                        </div>

                    </div>


                    <div class="card-body">

                        <label
                            class="form-label"
                            for="description"
                        >
                            الوصف
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            class="form-control<?= isset($errors['description']) ? ' is-invalid' : '' ?>"
                            rows="6"
                        ><?= htmlspecialchars(
                            $description ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?></textarea>

                        <?php if (isset($errors['description'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars(
                                    $errors['description'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </div>

                        <?php endif; ?>

                    </div>

                </div>


            </div>


            <!-- Sidebar -->

            <div class="col-lg-4">


                <!-- Status -->

                <div class="card mb-3">

                    <div class="card-header">

                        <h3 class="card-title">
                            حالة القضية
                        </h3>

                    </div>


                    <div class="card-body">

                        <label
                            class="form-label required"
                            for="status"
                        >
                            الحالة الحالية
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select<?= isset($errors['status']) ? ' is-invalid' : '' ?>"
                        >

                            <option
                                value="pending"
                                <?= $status === 'pending'
                                    ? 'selected'
                                    : '' ?>
                            >
                                قيد الانتظار
                            </option>

                            <option
                                value="active"
                                <?= $status === 'active'
                                    ? 'selected'
                                    : '' ?>
                            >
                                نشطة
                            </option>

                            <option
                                value="on_hold"
                                <?= $status === 'on_hold'
                                    ? 'selected'
                                    : '' ?>
                            >
                                معلقة
                            </option>

                            <option
                                value="closed"
                                <?= $status === 'closed'
                                    ? 'selected'
                                    : '' ?>
                            >
                                مغلقة
                            </option>

                            <option
                                value="cancelled"
                                <?= $status === 'cancelled'
                                    ? 'selected'
                                    : '' ?>
                            >
                                ملغاة
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


                <!-- Actions -->

                <div class="card">

                    <div class="card-body">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
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
                                class="icon icon-1"
                            >
                                <path d="M5 12l14 0" />
                                <path d="M12 5l0 14" />
                            </svg>

                            حفظ التعديلات

                        </button>


                        <a
                            href="?route=cases"
                            class="btn btn-outline-secondary w-100 mt-2"
                        >
                            إلغاء والعودة
                        </a>

                    </div>

                </div>


            </div>


        </div>

    </form>

</div>


<?php require __DIR__ . '/../layouts/footer.php'; ?>