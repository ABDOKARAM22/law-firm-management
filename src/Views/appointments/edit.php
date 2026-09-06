<?php

use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\Csrf;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

$statusLabels = [
    'scheduled' => 'مجدول',
    'completed' => 'مكتمل',
    'cancelled' => 'ملغي',
];

$pageTitle = 'تعديل الموعد';

require __DIR__ . '/../layouts/header.php';

?>

<div class="container-xl">

    <!-- Page Header -->
    <div class="page-header d-print-none mb-4">

        <div class="row align-items-center">

            <div class="col">

                <div class="page-pretitle">
                    المواعيد
                </div>

                <h2 class="page-title">
                    تعديل الموعد
                </h2>

            </div>

            <div class="col-auto">

                <a
                    href="?route=appointments"
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

                    العودة للمواعيد
                </a>

            </div>

        </div>

    </div>


    <!-- Validation Errors -->
    <?php if (!empty($errors)): ?>

        <div
            class="alert alert-danger mb-4"
            role="alert"
        >

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
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        ></circle>

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


    <form
        method="POST"
        action="?route=appointments/edit&id=<?= (int) $appointment['id'] ?>"
    >

        <input
            type="hidden"
            name="_token"
            value="<?= htmlspecialchars(Csrf::token()) ?>"
        >


        <!-- Appointment Information -->
        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title">
                    بيانات الموعد
                </h3>

            </div>

            <div class="card-body">

                <!-- Client -->
                <div class="mb-3">

                    <label
                        for="client_id"
                        class="form-label"
                    >
                        العميل
                    </label>

                    <?php
                    $selectedClient =
                        $old['client_id']
                        ?? $appointment['client_id'];
                    ?>

                    <select
                        name="client_id"
                        id="client_id"
                        class="form-select <?= isset($errors['client_id']) ? 'is-invalid' : '' ?>"
                    >

                        <option value="">
                            بدون عميل
                        </option>

                        <?php foreach ($clients as $client): ?>

                            <option
                                value="<?= (int) $client['id'] ?>"
                                <?= (string) $selectedClient ===
                                    (string) $client['id']
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= htmlspecialchars($client['name']) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                    <?php if (isset($errors['client_id'])): ?>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['client_id']) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- Assigned User -->
                <div class="mb-3">

                    <label
                        for="assigned_user_id"
                        class="form-label"
                    >
                        المسؤول عن الموعد
                    </label>

                    <?php if ($role === 'lawyer'): ?>

                        <input
                            type="text"
                            id="assigned_user_id"
                            class="form-control"
                            value="<?= htmlspecialchars($appointment['assigned_user_name']) ?>"
                            disabled
                        >

                        <div class="form-hint">
                            لا يمكنك تغيير المسؤول عن الموعد.
                        </div>

                    <?php else: ?>

                        <?php
                        $selectedUser =
                            $old['assigned_user_id']
                            ?? $appointment['assigned_user_id'];
                        ?>

                        <select
                            name="assigned_user_id"
                            id="assigned_user_id"
                            class="form-select <?= isset($errors['assigned_user_id']) ? 'is-invalid' : '' ?>"
                        >

                            <option value="">
                                اختر المسؤول
                            </option>

                            <?php foreach ($users as $user): ?>

                                <option
                                    value="<?= (int) $user['id'] ?>"
                                    <?= (string) $selectedUser ===
                                        (string) $user['id']
                                        ? 'selected'
                                        : '' ?>
                                >
                                    <?= htmlspecialchars($user['name']) ?>
                                    -
                                    <?= $user['role'] === 'lawyer'
                                        ? 'محامي'
                                        : 'موظف' ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    <?php endif; ?>

                    <?php if (isset($errors['assigned_user_id'])): ?>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['assigned_user_id']) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- Date & Time -->
                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label
                            for="appointment_date"
                            class="form-label"
                        >
                            التاريخ
                        </label>

                        <input
                            type="date"
                            name="appointment_date"
                            id="appointment_date"
                            class="form-control <?= isset($errors['appointment_date']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars(
                                $old['appointment_date']
                                ?? $appointment['appointment_date']
                            ) ?>"
                        >

                        <?php if (isset($errors['appointment_date'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['appointment_date']) ?>
                            </div>

                        <?php endif; ?>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label
                            for="appointment_time"
                            class="form-label"
                        >
                            الوقت
                        </label>

                        <input
                            type="time"
                            name="appointment_time"
                            id="appointment_time"
                            class="form-control <?= isset($errors['appointment_time']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars(
                                $old['appointment_time']
                                ?? $appointment['appointment_time']
                            ) ?>"
                        >

                        <?php if (isset($errors['appointment_time'])): ?>

                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['appointment_time']) ?>
                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>


        <!-- Appointment Details -->
        <div class="card mb-4">

            <div class="card-header">

                <h3 class="card-title">
                    تفاصيل الموعد
                </h3>

            </div>

            <div class="card-body">

                <!-- Title -->
                <div class="mb-3">

                    <label
                        for="title"
                        class="form-label"
                    >
                        عنوان الموعد
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                        value="<?= htmlspecialchars(
                            $old['title']
                            ?? $appointment['title']
                        ) ?>"
                    >

                    <?php if (isset($errors['title'])): ?>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['title']) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- Type -->
                <div class="mb-3">

                    <label
                        for="type"
                        class="form-label"
                    >
                        نوع الموعد
                    </label>

                    <input
                        type="text"
                        name="type"
                        id="type"
                        class="form-control <?= isset($errors['type']) ? 'is-invalid' : '' ?>"
                        value="<?= htmlspecialchars(
                            $old['type']
                            ?? $appointment['type']
                        ) ?>"
                    >

                    <?php if (isset($errors['type'])): ?>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['type']) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- Status -->
                <div class="mb-3">

                    <label
                        for="status"
                        class="form-label"
                    >
                        الحالة
                    </label>

                    <?php
                    $selectedStatus =
                        $old['status']
                        ?? $appointment['status'];
                    ?>

                    <select
                        name="status"
                        id="status"
                        class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>"
                    >

                        <?php foreach ($statusLabels as $status => $label): ?>

                            <option
                                value="<?= htmlspecialchars($status) ?>"
                                <?= $selectedStatus === $status
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


                <!-- Notes -->
                <div class="mb-0">

                    <label
                        for="notes"
                        class="form-label"
                    >
                        ملاحظات
                    </label>

                    <textarea
                        name="notes"
                        id="notes"
                        class="form-control"
                        rows="5"
                        placeholder="أضف أي ملاحظات خاصة بالموعد..."
                    ><?= htmlspecialchars(
                        $old['notes']
                        ?? $appointment['notes']
                        ?? ''
                    ) ?></textarea>

                    <?php if (isset($errors['notes'])): ?>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['notes']) ?>
                        </div>

                    <?php endif; ?>

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
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>

                        حفظ التعديلات
                    </button>

                    <a
                        href="?route=appointments"
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