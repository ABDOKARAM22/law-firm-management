<?php

use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\Csrf;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

$statusLabels = [
    'scheduled' => 'مجدولة',
    'completed' => 'منعقدة',
    'postponed' => 'مؤجلة',
    'cancelled' => 'ملغاة',
];

$pageTitle = 'إضافة جلسة';

require __DIR__ . '/../layouts/header.php';
?>

<div class="container-xl">

    <!-- Page Header -->
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">

            <div class="col">

                <div class="page-pretitle">
                    الجلسات
                </div>

                <h2 class="page-title">
                    إضافة جلسة جديدة
                </h2>

            </div>

            <div class="col-auto">

                <a
                    href="?route=cases/show&id=<?= (int) $case['id'] ?>"
                    class="btn btn-outline-secondary"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon"
                    >
                        <path d="M15 6l-6 6l6 6"></path>
                    </svg>

                    العودة للقضية
                </a>

            </div>

        </div>
    </div>

    <!-- Case Information -->
    <div class="card mb-4">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <span class="avatar avatar-md bg-blue-lt me-3">

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
                        <path d="M4 20h16"></path>
                        <path d="M6 20v-7"></path>
                        <path d="M10 20v-11"></path>
                        <path d="M14 20v-5"></path>
                        <path d="M18 20v-14"></path>
                    </svg>

                </span>

                <div>

                    <div class="text-secondary small mb-1">
                        القضية
                    </div>

                    <div class="fw-bold">
                        <?= htmlspecialchars($case['case_number']) ?>
                        -
                        <?= htmlspecialchars($case['title']) ?>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Validation Errors -->
    <?php if (!empty($errors)): ?>

        <div class="alert alert-danger mb-4" role="alert">

            <div class="d-flex">

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
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M12 8v4"></path>
                        <path d="M12 16h.01"></path>
                    </svg>
                </div>

                <div>
                    <h4 class="alert-title">
                        يرجى مراجعة البيانات
                    </h4>

                    <div>
                        توجد بعض الأخطاء في البيانات المدخلة.
                    </div>
                </div>

            </div>

        </div>

    <?php endif; ?>

    <!-- Hearing Form -->
    <form
        method="POST"
        action="?route=hearings/create&case_id=<?= (int) $case['id'] ?>"
    >

        <input
            type="hidden"
            name="_token"
            value="<?= htmlspecialchars(Csrf::token()) ?>"
        >

        <!-- Date & Time -->
        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title">
                    موعد الجلسة
                </h3>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label
                            for="hearing_date"
                            class="form-label"
                        >
                            تاريخ الجلسة
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            id="hearing_date"
                            name="hearing_date"
                            class="form-control <?= isset($errors['hearing_date']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($old['hearing_date'] ?? '') ?>"
                        >

                        <?php if (isset($errors['hearing_date'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['hearing_date']) ?>
                            </div>

                        <?php endif; ?>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label
                            for="hearing_time"
                            class="form-label"
                        >
                            وقت الجلسة
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="time"
                            id="hearing_time"
                            name="hearing_time"
                            class="form-control <?= isset($errors['hearing_time']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($old['hearing_time'] ?? '') ?>"
                        >

                        <?php if (isset($errors['hearing_time'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['hearing_time']) ?>
                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

        <!-- Court Information -->
        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title">
                    بيانات المحكمة
                </h3>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label
                            for="court_name"
                            class="form-label"
                        >
                            اسم المحكمة
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="court_name"
                            name="court_name"
                            class="form-control <?= isset($errors['court_name']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars(
                                $old['court_name'] ?? $case['court_name'] ?? ''
                            ) ?>"
                        >

                        <?php if (isset($errors['court_name'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['court_name']) ?>
                            </div>

                        <?php endif; ?>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label
                            for="court_number"
                            class="form-label"
                        >
                            رقم الدائرة
                        </label>

                        <input
                            type="text"
                            id="court_number"
                            name="court_number"
                            class="form-control"
                            value="<?= htmlspecialchars(
                                $old['court_number'] ?? $case['court_number'] ?? ''
                            ) ?>"
                        >

                    </div>

                </div>

            </div>

        </div>

        <!-- Hearing Details -->
        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title">
                    تفاصيل الجلسة
                </h3>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label
                            for="hearing_type"
                            class="form-label"
                        >
                            نوع الجلسة
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="hearing_type"
                            name="hearing_type"
                            class="form-control <?= isset($errors['hearing_type']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($old['hearing_type'] ?? '') ?>"
                        >

                        <?php if (isset($errors['hearing_type'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['hearing_type']) ?>
                            </div>

                        <?php endif; ?>

                    </div>

                    <div class="col-md-6 mb-3">

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
                        >

                            <?php foreach ($statusLabels as $value => $label): ?>

                                <option
                                    value="<?= htmlspecialchars($value) ?>"
                                    <?= ($old['status'] ?? 'scheduled') === $value
                                        ? 'selected'
                                        : '' ?>
                                >
                                    <?= htmlspecialchars($label) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                        <?php if (isset($errors['status'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['status']) ?>
                            </div>

                        <?php endif; ?>

                    </div>

                </div>

                <div class="mb-0">

                    <label
                        for="notes"
                        class="form-label"
                    >
                        ملاحظات
                    </label>

                    <textarea
                        id="notes"
                        name="notes"
                        class="form-control"
                        rows="5"
                    ><?= htmlspecialchars($old['notes'] ?? '') ?></textarea>

                    <div class="form-hint">
                        يمكنك إضافة أي ملاحظات أو تفاصيل مهمة متعلقة بالجلسة.
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
                            width="20"
                            height="20"
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

                        إضافة الجلسة
                    </button>

                    <a
                        href="?route=cases/show&id=<?= (int) $case['id'] ?>"
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