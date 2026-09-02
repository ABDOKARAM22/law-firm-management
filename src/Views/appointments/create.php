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

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إضافة موعد</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            background-color: #f5f7fa;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 30px;
            text-align: center;
            color: #1f2937;
            font-size: 28px;
        }

        .errors {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 15px 20px;
            border-radius: 7px;
            margin-bottom: 25px;
        }

        .errors ul {
            margin: 0;
            padding-right: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #374151;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 15px;
            font-family: inherit;
            background-color: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .field-error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 14px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .submit-btn {
            width: 100%;
            margin-top: 10px;
            padding: 13px;
            border: none;
            border-radius: 6px;
            background-color: #2563eb;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .submit-btn:hover {
            background-color: #1d4ed8;
        }

        .assigned-user {
            background-color: #f9fafb;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px 10px;
            }

            .container {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>

</head>

<body>

<div class="container">

    <h1>إضافة موعد</h1>



    <form method="POST" action="?route=appointments/create">

        <input
            type="hidden"
            name="_token"
            value="<?= htmlspecialchars(Csrf::token()) ?>"
        >


        <div class="form-group">

            <label for="client_id">
                العميل
            </label>

            <select
                name="client_id"
                id="client_id"
            >

                <option value="">
                    بدون عميل
                </option>

                <?php foreach ($clients as $client): ?>

                    <option
                        value="<?= (int) $client['id'] ?>"
                        <?= (
                            (string) ($old['client_id'] ?? '') ===
                            (string) $client['id']
                        ) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($client['name']) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <?php if (isset($errors['client_id'])): ?>

                <div class="field-error">
                    <?= htmlspecialchars($errors['client_id']) ?>
                </div>

            <?php endif; ?>

        </div>


        <?php if ($role !== 'lawyer'): ?>

            <div class="form-group">

                <label for="assigned_user_id">
                    المسؤول عن الموعد
                </label>

                <select
                    name="assigned_user_id"
                    id="assigned_user_id"
                >

                    <option value="">
                        اختر المسؤول
                    </option>

                    <?php foreach ($users as $user): ?>

                        <option
                            value="<?= (int) $user['id'] ?>"
                            <?= (
                                (string) ($old['assigned_user_id'] ?? '') ===
                                (string) $user['id']
                            ) ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($user['name']) ?>

                            -
                            
                            <?= $user['role'] === 'lawyer'
                                ? 'محامي'
                                : 'موظف' ?>
                        </option>

                    <?php endforeach; ?>

                </select>

                <?php if (isset($errors['assigned_user_id'])): ?>

                    <div class="field-error">
                        <?= htmlspecialchars($errors['assigned_user_id']) ?>
                    </div>

                <?php endif; ?>

            </div>

        <?php else: ?>

            <div class="form-group">

                <label for="assigned_user">
                    المسؤول عن الموعد
                </label>

                <input
                    type="text"
                    id="assigned_user"
                    class="assigned-user"
                    value="أنت المسؤول عن هذا الموعد"
                    disabled
                >

            </div>

        <?php endif; ?>


        <div class="form-row">

            <div class="form-group">

                <label for="appointment_date">
                    التاريخ
                </label>

                <input
                    type="date"
                    name="appointment_date"
                    id="appointment_date"
                    value="<?= htmlspecialchars(
                        $old['appointment_date'] ?? ''
                    ) ?>"
                >

                <?php if (isset($errors['appointment_date'])): ?>

                    <div class="field-error">
                        <?= htmlspecialchars($errors['appointment_date']) ?>
                    </div>

                <?php endif; ?>

            </div>


            <div class="form-group">

                <label for="appointment_time">
                    الوقت
                </label>

                <input
                    type="time"
                    name="appointment_time"
                    id="appointment_time"
                    value="<?= htmlspecialchars(
                        $old['appointment_time'] ?? ''
                    ) ?>"
                >

                <?php if (isset($errors['appointment_time'])): ?>

                    <div class="field-error">
                        <?= htmlspecialchars($errors['appointment_time']) ?>
                    </div>

                <?php endif; ?>

            </div>

        </div>


        <div class="form-group">

            <label for="title">
                عنوان الموعد
            </label>

            <input
                type="text"
                name="title"
                id="title"
                value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                placeholder="مثال: مقابلة مع العميل"
            >

            <?php if (isset($errors['title'])): ?>

                <div class="field-error">
                    <?= htmlspecialchars($errors['title']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="type">
                نوع الموعد
            </label>

            <input
                type="text"
                name="type"
                id="type"
                value="<?= htmlspecialchars($old['type'] ?? '') ?>"
                placeholder="مثال: مقابلة - استشارة - متابعة"
            >

            <?php if (isset($errors['type'])): ?>

                <div class="field-error">
                    <?= htmlspecialchars($errors['type']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="status">
                الحالة
            </label>

            <select
                name="status"
                id="status"
            >

                <?php foreach ($statusLabels as $status => $label): ?>

                    <option
                        value="<?= $status ?>"
                        <?= (
                            ($old['status'] ?? 'scheduled') === $status
                        ) ? 'selected' : '' ?>
                    >
                        <?= $label ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <?php if (isset($errors['status'])): ?>

                <div class="field-error">
                    <?= htmlspecialchars($errors['status']) ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="notes">
                ملاحظات
            </label>

            <textarea
                name="notes"
                id="notes"
                rows="5"
                placeholder="أضف أي ملاحظات خاصة بالموعد..."
            ><?= htmlspecialchars($old['notes'] ?? '') ?></textarea>

            <?php if (isset($errors['notes'])): ?>

                <div class="field-error">
                    <?= htmlspecialchars($errors['notes']) ?>
                </div>

            <?php endif; ?>

        </div>


        <button
            type="submit"
            class="submit-btn"
        >
            حفظ الموعد
        </button>

    </form>

</div>

</body>
</html>