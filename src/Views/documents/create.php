<?php

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

$pageTitle = 'إضافة مستند';

require __DIR__ . '/../layouts/header.php';

?>

<div class="container-xl">

    <!-- Page Header -->
    <div class="page-header d-print-none mb-3">

        <div class="row align-items-center">

            <div class="col">

                <div class="page-pretitle">
                    مستندات القضية
                </div>

                <h2 class="page-title">
                    إضافة مستند جديد
                </h2>

            </div>

            <div class="col-auto ms-auto">

                <a
                    href="?route=cases/documents&id=<?= (int) $case['id'] ?>"
                    class="btn btn-outline-secondary"
                >
                    <i class="ti ti-arrow-right me-1"></i>
                    العودة إلى المستندات
                </a>

            </div>

        </div>

    </div>

    <!-- Case Information -->
    <div class="card mb-3">

        <div class="card-header">

            <h3 class="card-title">
                <i class="ti ti-briefcase me-1"></i>
                بيانات القضية
            </h3>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3 mb-md-0">

                    <div class="text-secondary">
                        رقم القضية
                    </div>

                    <div class="fw-bold">
                        <?= htmlspecialchars($case['case_number']) ?>
                    </div>

                </div>

                <div class="col-md-8">

                    <div class="text-secondary">
                        عنوان القضية
                    </div>

                    <div class="fw-bold">
                        <?= htmlspecialchars($case['title']) ?>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Document Form -->
    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                بيانات المستند
            </h3>

        </div>

        <div class="card-body">

            <?php if (!empty($errors)): ?>

                <div
                    class="alert alert-danger"
                    role="alert"
                >

                    <div class="d-flex">

                        <div>
                            <i class="ti ti-alert-circle me-2"></i>
                        </div>

                        <div>

                            <h4 class="alert-title">
                                يرجى تصحيح الأخطاء التالية
                            </h4>

                            <div class="text-secondary">

                                <ul class="mb-0">

                                    <?php foreach ($errors as $error): ?>

                                        <li>
                                            <?= htmlspecialchars($error) ?>
                                        </li>

                                    <?php endforeach; ?>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

            <form
                method="POST"
                action="?route=documents/create&case_id=<?= (int) $case['id'] ?>"
                enctype="multipart/form-data"
            >

                <input
                    type="hidden"
                    name="_token"
                    value="<?= htmlspecialchars(Csrf::token()) ?>"
                >

                <div class="mb-3">

                    <label
                        for="title"
                        class="form-label"
                    >
                        عنوان المستند
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                        value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                        placeholder="مثال: عقد البيع"
                        required
                    >

                    <?php if (isset($errors['title'])): ?>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['title']) ?>
                        </div>

                    <?php endif; ?>

                </div>

                <div class="mb-3">

                    <label
                        for="file"
                        class="form-label"
                    >
                        ملف المستند
                    </label>

                    <input
                        type="file"
                        id="file"
                        name="file"
                        class="form-control <?= isset($errors['file']) ? 'is-invalid' : '' ?>"
                        required
                    >

                    <?php if (isset($errors['file'])): ?>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['file']) ?>
                        </div>

                    <?php endif; ?>

                    <div class="form-hint">
                        الملفات المسموح بها: PDF, JPG, PNG, DOC, DOCX — الحد الأقصى 5 MB.
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="?route=cases/documents&id=<?= (int) $case['id'] ?>"
                        class="btn btn-outline-secondary"
                    >
                        إلغاء
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="ti ti-upload me-1"></i>

                        رفع المستند

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php

require __DIR__ . '/../layouts/footer.php';