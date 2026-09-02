<?php

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];
?>

<h1>إضافة قضية</h1>

<form method="POST" action="?route=cases/create">

    <input
        type="hidden"
        name="_token"
        value="<?= htmlspecialchars(
            Csrf::token(),
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
    >

    <div>
        <label for="case_number">
            رقم القضية
        </label>

        <input
            type="text"
            id="case_number"
            name="case_number"
            value="<?= htmlspecialchars(
                $old['case_number'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >

        <?php if (isset($errors['case_number'])): ?>
            <div>
                <?= htmlspecialchars(
                    $errors['case_number'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <label for="title">
            عنوان القضية
        </label>

        <input
            type="text"
            id="title"
            name="title"
            value="<?= htmlspecialchars(
                $old['title'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >

        <?php if (isset($errors['title'])): ?>
            <div>
                <?= htmlspecialchars(
                    $errors['title'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <label for="client_id">
            العميل
        </label>

        <select name="client_id" id="client_id">

            <option value="">
                اختر العميل
            </option>

            <?php foreach ($clients as $client): ?>

                <option
                    value="<?= (int) $client['id'] ?>"
                    <?= (($old['client_id'] ?? '') == $client['id'])
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
            <div>
                <?= htmlspecialchars(
                    $errors['client_id'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <label for="assigned_lawyer_id">
            المحامي المسؤول
        </label>

        <select
            name="assigned_lawyer_id"
            id="assigned_lawyer_id"
        >

            <option value="">
                اختر المحامي
            </option>

            <?php foreach ($lawyers as $lawyer): ?>

                <option
                    value="<?= (int) $lawyer['id'] ?>"
                    <?= (($old['assigned_lawyer_id'] ?? '') == $lawyer['id'])
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
            <div>
                <?= htmlspecialchars(
                    $errors['assigned_lawyer_id'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <label for="case_type_id">
            نوع القضية
        </label>

        <select name="case_type_id" id="case_type_id">

            <option value="">
                اختر نوع القضية
            </option>

            <?php foreach ($caseTypes as $caseType): ?>

                <option
                    value="<?= (int) $caseType['id'] ?>"
                    <?= (($old['case_type_id'] ?? '') == $caseType['id'])
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
            <div>
                <?= htmlspecialchars(
                    $errors['case_type_id'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <label for="court_name">
            اسم المحكمة
        </label>

        <input
            type="text"
            id="court_name"
            name="court_name"
            value="<?= htmlspecialchars(
                $old['court_name'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >
    </div>

    <div>
        <label for="court_number">
            رقم الدائرة
        </label>

        <input
            type="text"
            id="court_number"
            name="court_number"
            value="<?= htmlspecialchars(
                $old['court_number'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >
    </div>

    <div>
        <label for="status">
            الحالة
        </label>

        <select name="status" id="status">

            <?php
            $selectedStatus =
                $old['status'] ?? 'pending';
            ?>

            <option
                value="pending"
                <?= $selectedStatus === 'pending'
                    ? 'selected'
                    : '' ?>
            >
                قيد الانتظار
            </option>

            <option
                value="active"
                <?= $selectedStatus === 'active'
                    ? 'selected'
                    : '' ?>
            >
                نشطة
            </option>

            <option
                value="on_hold"
                <?= $selectedStatus === 'on_hold'
                    ? 'selected'
                    : '' ?>
            >
                معلقة
            </option>

            <option
                value="closed"
                <?= $selectedStatus === 'closed'
                    ? 'selected'
                    : '' ?>
            >
                مغلقة
            </option>

            <option
                value="cancelled"
                <?= $selectedStatus === 'cancelled'
                    ? 'selected'
                    : '' ?>
            >
                ملغاة
            </option>

        </select>
    </div>

    <div>
        <label for="filing_date">
            تاريخ رفع القضية
        </label>

        <input
            type="date"
            id="filing_date"
            name="filing_date"
            value="<?= htmlspecialchars(
                $old['filing_date'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >
    </div>

    <div>
        <label for="description">
            الوصف
        </label>

        <textarea
            id="description"
            name="description"
        ><?= htmlspecialchars(
            $old['description'] ?? '',
            ENT_QUOTES,
            'UTF-8'
        ) ?></textarea>
    </div>

    <button type="submit">
        حفظ القضية
    </button>

</form>