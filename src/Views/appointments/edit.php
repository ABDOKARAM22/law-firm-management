<?php

use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\Csrf;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تعديل الموعد</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            background: #f5f6fa;
            font-family: Arial, Tahoma, sans-serif;
            color: #2d3436;
        }

        h1 {
            max-width: 700px;
            margin: 0 auto 25px;
            font-size: 28px;
            color: #2c3e50;
        }

        form {
            max-width: 700px;
            margin: 0 auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495e;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px 12px;
            margin-bottom: 8px;
            border: 1px solid #dcdfe6;
            border-radius: 6px;
            font-size: 15px;
            font-family: inherit;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.12);
        }

        input:disabled {
            background: #f1f2f6;
            color: #636e72;
            cursor: not-allowed;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .field {
            margin-bottom: 20px;
        }

        .error {
            margin-top: 4px;
            margin-bottom: 12px;
            color: #e74c3c;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: none;
            border-radius: 6px;
            background: #3498db;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #2980b9;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px 10px;
            }

            form {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<h1>تعديل الموعد</h1>

<form method="POST" action="?route=appointments/edit&id=<?= (int) $appointment['id'] ?>" >

    <input
        type="hidden"
        name="_token"
        value="<?= htmlspecialchars(
            LawFirmManagement\Core\Csrf::token()
        ) ?>"
    >

    <!-- Client -->

    <div class="field">

        <label for="client_id">العميل</label>

        <select name="client_id" id="client_id">

            <option value="">بدون عميل</option>

            <?php foreach ($clients as $client): ?>

                <?php
                $selectedClient =
                    $old['client_id']
                    ?? $appointment['client_id'];
                ?>

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

            <div class="error">
                <?= htmlspecialchars($errors['client_id']) ?>
            </div>

        <?php endif; ?>

    </div>


    <!-- Assigned User -->

    <div class="field">

        <label for="assigned_user_id">المسؤول عن الموعد</label>

        <?php if ($role === 'lawyer'): ?>

            <input
                type="text"
                value="<?= htmlspecialchars($appointment['assigned_user_name']) ?>"
                disabled
            >

        <?php else: ?>

            <?php
            $selectedUser =
                $old['assigned_user_id']
                ?? $appointment['assigned_user_id'];
            ?>

            <select
                name="assigned_user_id"
                id="assigned_user_id"
            >

                <option value="">اختر المسؤول</option>

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

            <div class="error">
                <?= htmlspecialchars($errors['assigned_user_id']) ?>
            </div>

        <?php endif; ?>

    </div>


    <!-- Date -->

    <div class="field">

        <label for="appointment_date">التاريخ</label>

        <input
            type="date"
            name="appointment_date"
            id="appointment_date"
            value="<?= htmlspecialchars(
                $old['appointment_date']
                ?? $appointment['appointment_date']
            ) ?>"
        >

        <?php if (isset($errors['appointment_date'])): ?>

            <div class="error">
                <?= htmlspecialchars($errors['appointment_date']) ?>
            </div>

        <?php endif; ?>

    </div>


    <!-- Time -->

    <div class="field">

        <label for="appointment_time">الوقت</label>

        <input
            type="time"
            name="appointment_time"
            id="appointment_time"
            value="<?= htmlspecialchars(
                $old['appointment_time']
                ?? $appointment['appointment_time']
            ) ?>"
        >

        <?php if (isset($errors['appointment_time'])): ?>

            <div class="error">
                <?= htmlspecialchars($errors['appointment_time']) ?>
            </div>

        <?php endif; ?>

    </div>


    <!-- Title -->

    <div class="field">

        <label for="title">عنوان الموعد</label>

        <input
            type="text"
            name="title"
            id="title"
            value="<?= htmlspecialchars(
                $old['title']
                ?? $appointment['title']
            ) ?>"
        >

        <?php if (isset($errors['title'])): ?>

            <div class="error">
                <?= htmlspecialchars($errors['title']) ?>
            </div>

        <?php endif; ?>

    </div>


    <!-- Type -->

    <div class="field">

        <label for="type">نوع الموعد</label>

        <input
            type="text"
            name="type"
            id="type"
            value="<?= htmlspecialchars(
                $old['type']
                ?? $appointment['type']
            ) ?>"
        >

        <?php if (isset($errors['type'])): ?>

            <div class="error">
                <?= htmlspecialchars($errors['type']) ?>
            </div>

        <?php endif; ?>

    </div>


    <!-- Status -->

    <div class="field">

        <label for="status">الحالة</label>

        <?php
        $selectedStatus =
            $old['status']
            ?? $appointment['status'];
        ?>

        <select name="status" id="status">

            <option
                value="scheduled"
                <?= $selectedStatus === 'scheduled'
                    ? 'selected'
                    : '' ?>
            >
                مجدول
            </option>

            <option
                value="completed"
                <?= $selectedStatus === 'completed'
                    ? 'selected'
                    : '' ?>
            >
                مكتمل
            </option>

            <option
                value="cancelled"
                <?= $selectedStatus === 'cancelled'
                    ? 'selected'
                    : '' ?>
            >
                ملغي
            </option>

        </select>

    </div>


    <!-- Notes -->

    <div class="field">

        <label for="notes">ملاحظات</label>

        <textarea
            name="notes"
            id="notes"
        ><?= htmlspecialchars(
            $old['notes']
            ?? $appointment['notes']
            ?? ''
        ) ?></textarea>

        <?php if (isset($errors['notes'])): ?>

            <div class="error">
                <?= htmlspecialchars($errors['notes']) ?>
            </div>

        <?php endif; ?>

    </div>


    <button type="submit">
        حفظ التعديلات
    </button>

</form>

</body>
</html>