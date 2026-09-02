<?php

use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\Csrf;

$success = Flash::get('success');

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

    <title>المواعيد</title>

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
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
            color: #1f2937;
            font-size: 28px;
        }

        .add-btn {
            display: inline-block;
            padding: 10px 18px;
            background-color: #2563eb;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 15px;
            transition: background-color 0.2s;
        }

        .add-btn:hover {
            background-color: #1d4ed8;
        }

        .success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            padding: 13px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th,
        td {
            padding: 13px 12px;
            text-align: right;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background-color: #f9fafb;
            color: #374151;
            font-weight: bold;
            white-space: nowrap;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .status-scheduled {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .status-completed {
            background-color: #dcfce7;
            color: #15803d;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .edit-btn {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        .edit-btn:hover {
            text-decoration: underline;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #6b7280;
        }

        @media (max-width: 700px) {
            body {
                padding: 20px 10px;
            }

            .container {
                padding: 20px;
            }

            .header {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }

            .add-btn {
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>المواعيد</h1>

        <a
            href="?route=appointments/create"
            class="add-btn"
        >
            + إضافة موعد
        </a>
    </div>


    <?php if ($success): ?>

        <div class="success">
            <?= htmlspecialchars($success) ?>
        </div>

    <?php endif; ?>


    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>العميل</th>
                    <th>المسؤول</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>العنوان</th>
                    <th>النوع</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>

            <tbody>

            <?php if (empty($appointments)): ?>

                <tr>
                    <td colspan="8" class="empty">
                        لا توجد مواعيد.
                    </td>
                </tr>

            <?php else: ?>

                <?php foreach ($appointments as $appointment): ?>

                    <tr>

                        <td>
                            <?= $appointment['client_name']
                                ? htmlspecialchars($appointment['client_name'])
                                : 'بدون عميل' ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($appointment['assigned_user_name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($appointment['appointment_date']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($appointment['appointment_time']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($appointment['title']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($appointment['type']) ?>
                        </td>

                        <td>
                            <?php
                            $status = $appointment['status'];
                            $statusLabel = $statusLabels[$status] ?? $status;
                            ?>

                            <span class="status status-<?= htmlspecialchars($status) ?>">
                                <?= htmlspecialchars($statusLabel) ?>
                            </span>
                        </td>

                        <td>
                            <a
                                href="?route=appointments/edit&id=<?= (int) $appointment['id'] ?>"
                                class="edit-btn"
                            >
                                تعديل
                            </a>
                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>