<?php

use LawFirmManagement\Core\Flash;

$success = Flash::get('success');
$errors = Flash::get('errors');

?>

<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <title>القضايا</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #333;
            color: white;
            border-radius: 5px;
        }

        .edit-btn {
            display: inline-block;
            padding: 7px 12px;
            background: #007bff;
            color: white;
            border-radius: 5px;
        }

        .success {
            padding: 10px;
            background: #d4edda;
            color: #155724;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: right;
        }

        th {
            background: #eee;
        }

        .empty {
            text-align: center;
            padding: 30px;
            background: white;
        }
    </style>

</head>

<body>

<div class="container">

    <div class="header">

        <h1>القضايا</h1>

        <a href="?route=cases/create" class="btn">
            إضافة قضية
        </a>

    </div>

    <?php if ($success): ?>

        <div class="success">
            <?= htmlspecialchars($success) ?>
        </div>

    <?php endif; ?>

    <?php if (empty($cases)): ?>

        <div class="empty">
            لا توجد قضايا مسجلة حاليًا.
        </div>

    <?php else: ?>

        <table>

            <thead>

                <tr>
                    <th>#</th>
                    <th>رقم القضية</th>
                    <th>عنوان القضية</th>
                    <th>العميل</th>
                    <th>المحامي</th>
                    <th>نوع القضية</th>
                    <th>المحكمة</th>
                    <th>الحالة</th>
                    <th>تاريخ القيد</th>
                    <th>الإجراءات</th>
                </tr>

            </thead>

            <tbody>

            <?php foreach ($cases as $case): ?>

                <tr>

                    <td>
                        <?= (int) $case['id'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['case_number']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['title']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['client_name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['lawyer_name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['case_type_name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['court_name']) ?>

                        <?php if (!empty($case['court_number'])): ?>
                            - <?= htmlspecialchars($case['court_number']) ?>
                        <?php endif; ?>

                    </td>

                    <td>
                        <?= htmlspecialchars($case['status']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['filing_date'] ?? '') ?>
                    </td>

                    <td>
                        <a
                            href="?route=cases/edit&id=<?= (int) $case['id'] ?>"
                            class="edit-btn"
                        >
                            تعديل
                        </a>
                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</div>

</body>

</html>