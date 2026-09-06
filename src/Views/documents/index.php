<?php

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;

$success = Flash::get('success');

$pageTitle = 'مستندات القضية';

require __DIR__ . '/../layouts/header.php';

?>

<div class="container-xl">

    <!-- Page Header -->
    <div class="page-header d-print-none mb-3">

        <div class="row align-items-center">

            <div class="col">

                <div class="page-pretitle">
                    إدارة مستندات القضية
                </div>

                <h2 class="page-title">
                    مستندات القضية
                </h2>

            </div>

            <div class="col-auto ms-auto">

                <div class="btn-list">

                    <a
                        href="?route=documents/create&case_id=<?= (int) $caseId ?>"
                        class="btn btn-primary"
                    >
                        <i class="ti ti-file-plus me-1"></i>
                        إضافة مستند
                    </a>

                    <a
                        href="?route=cases/show&id=<?= (int) $caseId ?>"
                        class="btn btn-outline-secondary"
                    >
                        <i class="ti ti-arrow-right me-1"></i>
                        العودة إلى القضية
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- Success Message -->
    <?php if ($success): ?>

        <div
            class="alert alert-success alert-dismissible"
            role="alert"
        >

            <div class="d-flex">

                <div>
                    <i class="ti ti-check"></i>
                </div>

                <div>
                    <?= htmlspecialchars($success) ?>
                </div>

            </div>

            <a
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="إغلاق"
            ></a>

        </div>

    <?php endif; ?>

    <!-- Documents Card -->
    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                قائمة المستندات
            </h3>

        </div>

        <?php if (!empty($documents)): ?>

            <div class="table-responsive">

                <table class="table table-vcenter card-table">

                    <thead>

                        <tr>

                            <th>العنوان</th>

                            <th>اسم الملف</th>

                            <th>نوع الملف</th>

                            <th>الحجم</th>

                            <th>تم الرفع بواسطة</th>

                            <th>تاريخ الرفع</th>

                            <th class="w-1">
                                الإجراءات
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($documents as $document): ?>

                        <tr>

                            <td>

                                <div class="fw-bold">
                                    <?= htmlspecialchars($document['title']) ?>
                                </div>

                            </td>

                            <td>

                                <div class="text-secondary">

                                    <i class="ti ti-file me-1"></i>

                                    <?= htmlspecialchars($document['file_name']) ?>

                                </div>

                            </td>

                            <td>

                                <span class="badge bg-secondary-lt">

                                    <?= htmlspecialchars($document['file_type']) ?>

                                </span>

                            </td>

                            <td>

                                <?= number_format(
                                    $document['file_size'] / 1024,
                                    2
                                ) ?>

                                KB

                            </td>

                            <td>

                                <div class="d-flex align-items-center">

                                    <i class="ti ti-user me-1 text-secondary"></i>

                                    <?= htmlspecialchars(
                                        $document['uploaded_by_name']
                                    ) ?>

                                </div>

                            </td>

                            <td>

                                <span class="text-secondary">

                                    <?= htmlspecialchars(
                                        $document['created_at']
                                    ) ?>

                                </span>

                            </td>

                            <td>

                                <div class="btn-list flex-nowrap">

                                    <a
                                        href="?route=documents/download&id=<?= (int) $document['id'] ?>"
                                        class="btn btn-sm btn-outline-primary"
                                        title="تحميل المستند"
                                    >

                                        <i class="ti ti-download"></i>

                                        <span class="d-none d-md-inline">
                                            تحميل
                                        </span>

                                    </a>

                                    <a
                                        href="?route=documents/edit&id=<?= (int) $document['id'] ?>"
                                        class="btn btn-sm btn-outline-warning"
                                        title="تعديل المستند"
                                    >

                                        <i class="ti ti-edit"></i>

                                        <span class="d-none d-md-inline">
                                            تعديل
                                        </span>

                                    </a>

                                    <form
                                        method="POST"
                                        action="?route=documents/delete&id=<?= (int) $document['id'] ?>"
                                        class="d-inline"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا المستند؟');"
                                    >

                                        <input
                                            type="hidden"
                                            name="_token"
                                            value="<?= htmlspecialchars(
                                                Csrf::token()
                                            ) ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="حذف المستند"
                                        >

                                            <i class="ti ti-trash"></i>

                                            <span class="d-none d-md-inline">
                                                حذف
                                            </span>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <!-- Empty State -->
            <div class="card-body">

                <div class="empty">

                    <div class="empty-img">
                        <i
                            class="ti ti-file-off"
                            style="font-size: 4rem;"
                        ></i>
                    </div>

                    <p class="empty-title">
                        لا توجد مستندات
                    </p>

                    <p class="empty-subtitle text-secondary">
                        لم تتم إضافة أي مستندات إلى هذه القضية حتى الآن.
                    </p>

                    <div class="empty-action">

                        <a
                            href="?route=documents/create&case_id=<?= (int) $caseId ?>"
                            class="btn btn-primary"
                        >

                            <i class="ti ti-file-plus me-1"></i>

                            إضافة أول مستند

                        </a>

                    </div>

                </div>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php

require __DIR__ . '/../layouts/footer.php';