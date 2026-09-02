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

?>

<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <title>تعديل القضية</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .actions {
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            margin-right: 8px;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>تعديل القضية</h1>

    <form method="POST" action="?route=cases/edit&id=<?=  $case['id'] ?>">

        <input
            type="hidden"
            name="_token"
            value="<?= htmlspecialchars(Csrf::token()) ?>"
        >

        <div class="form-group">

            <label for="case_number">
                رقم القضية
            </label>

            <input
                type="text"
                id="case_number"
                name="case_number"
                value="<?= htmlspecialchars($caseNumber) ?>"
            >

            <?php if (isset($errors['case_number'])): ?>

                <div class="error">
                    <?= htmlspecialchars($errors['case_number']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="title">
                عنوان القضية
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="<?= htmlspecialchars($title) ?>"
            >

            <?php if (isset($errors['title'])): ?>

                <div class="error">
                    <?= htmlspecialchars($errors['title']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="client_id">
                العميل
            </label>

            <select id="client_id" name="client_id">

                <option value="">
                    اختر العميل
                </option>

                <?php foreach ($clients as $client): ?>

                    <option
                        value="<?= (int) $client['id'] ?>"
                        <?= (string) $clientId === (string) $client['id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($client['name']) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <?php if (isset($errors['client_id'])): ?>

                <div class="error">
                    <?= htmlspecialchars($errors['client_id']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="assigned_lawyer_id">
                المحامي المسؤول
            </label>

            <select
                id="assigned_lawyer_id"
                name="assigned_lawyer_id"
            >

                <option value="">
                    اختر المحامي
                </option>

                <?php foreach ($lawyers as $lawyer): ?>

                    <option
                        value="<?= (int) $lawyer['id'] ?>"
                        <?= (string) $assignedLawyerId === (string) $lawyer['id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($lawyer['name']) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <?php if (isset($errors['assigned_lawyer_id'])): ?>

                <div class="error">
                    <?= htmlspecialchars($errors['assigned_lawyer_id']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="case_type_id">
                نوع القضية
            </label>

            <select id="case_type_id" name="case_type_id">

                <option value="">
                    اختر نوع القضية
                </option>

                <?php foreach ($caseTypes as $caseType): ?>

                    <option
                        value="<?= (int) $caseType['id'] ?>"
                        <?= (string) $caseTypeId === (string) $caseType['id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($caseType['name']) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <?php if (isset($errors['case_type_id'])): ?>

                <div class="error">
                    <?= htmlspecialchars($errors['case_type_id']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="court_name">
                اسم المحكمة
            </label>

            <input
                type="text"
                id="court_name"
                name="court_name"
                value="<?= htmlspecialchars($courtName) ?>"
            >

            <?php if (isset($errors['court_name'])): ?>

                <div class="error">
                    <?= htmlspecialchars($errors['court_name']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="court_number">
                رقم المحكمة
            </label>

            <input
                type="text"
                id="court_number"
                name="court_number"
                value="<?= htmlspecialchars($courtNumber ?? '') ?>"
            >

            <?php if (isset($errors['court_number'])): ?>

                <div class="error">
                    <?= htmlspecialchars($errors['court_number']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="status">
                حالة القضية
            </label>

            <select id="status" name="status">

                <option
                    value="pending"
                    <?= $status === 'pending' ? 'selected' : '' ?>
                >
                    قيد الانتظار
                </option>

                <option
                    value="active"
                    <?= $status === 'active' ? 'selected' : '' ?>
                >
                    نشطة
                </option>

                <option
                    value="on_hold"
                    <?= $status === 'on_hold' ? 'selected' : '' ?>
                >
                    معلقة
                </option>

                <option
                    value="closed"
                    <?= $status === 'closed' ? 'selected' : '' ?>
                >
                    مغلقة
                </option>

                <option
                    value="cancelled"
                    <?= $status === 'cancelled' ? 'selected' : '' ?>
                >
                    ملغاة
                </option>

            </select>

            <?php if (isset($errors['status'])): ?>

                <div class="error">
                    <?= htmlspecialchars($errors['status']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="description">
                الوصف
            </label>

            <textarea
                id="description"
                name="description"
            ><?= htmlspecialchars($description ?? '') ?></textarea>

            <?php if (isset($errors['description'])): ?>

                <div class="error">
                    <?= htmlspecialchars($errors['description']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="filing_date">
                تاريخ القيد
            </label>

            <input
                type="date"
                id="filing_date"
                name="filing_date"
                value="<?= htmlspecialchars($filingDate ?? '') ?>"
            >

            <?php if (isset($errors['filing_date'])): ?>

                <div class="error">
                    <?= htmlspecialchars($errors['filing_date']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                حفظ التعديلات
            </button>

            <a
                href="?route=cases"
                class="btn btn-secondary"
            >
                إلغاء
            </a>

        </div>

    </form>

</div>

</body>

</html>