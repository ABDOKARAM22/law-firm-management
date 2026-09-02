<?php

use LawFirmManagement\Core\Flash;

$statusLabels = [
    'pending' => 'قيد الانتظار',
    'active' => 'نشطة',
    'on_hold' => 'معلقة',
    'closed' => 'مغلقة',
    'cancelled' => 'ملغاة',
];

$hearingStatusLabels = [
    'scheduled' => 'مجدولة',
    'completed' => 'مكتملة',
    'postponed' => 'مؤجلة',
    'cancelled' => 'ملغاة',
];

$oldStatusLabel = static function (?string $status) use ($statusLabels): string {
    if ($status === null || $status === '') {
        return '—';
    }

    return $statusLabels[$status] ?? $status;
};

?>

<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>تفاصيل القضية</title>

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
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            margin-bottom: 15px;
        }

        .case-info,
        .history,
        .hearings {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .case-info th,
        .case-info td,
        .history th,
        .history td,
        .hearings th,
        .hearings td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: right;
        }

        .case-info th,
        .history th,
        .hearings th {
            background: #eee;
        }

        .case-info th {
            width: 200px;
        }

        .description {
            line-height: 1.8;
            white-space: normal;
        }

        .empty {
            text-align: center;
            padding: 30px;
            background: white;
            border: 1px solid #ddd;
        }

        .actions {
            margin-top: 20px;
        }

        .actions a {
            margin-left: 10px;
        }

        .status-change {
            font-weight: bold;
        }

        .hearing-status {
            font-weight: bold;
        }

        @media (max-width: 768px) {

            body {
                margin: 20px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .case-info th {
                width: 120px;
            }

            .history,
            .hearings {
                font-size: 14px;
            }

            .history th,
            .history td,
            .hearings th,
            .hearings td {
                padding: 8px;
            }

        }

    </style>

</head>

<body>

<div class="container">


    <!-- Header -->

    <div class="header">

        <h1>تفاصيل القضية</h1>

        <a href="?route=cases" class="btn">
            العودة إلى القضايا
        </a>

    </div>


    <!-- Success Message -->

    <?php if ($message = Flash::get('success')): ?>

        <div class="success">

            <?= htmlspecialchars(
                $message,
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </div>

    <?php endif; ?>


    <!-- Case Information -->

    <section class="section">

        <h2>معلومات القضية</h2>

        <table class="case-info">

            <tr>

                <th>رقم القضية</th>

                <td>
                    <?= htmlspecialchars(
                        $case['case_number'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>عنوان القضية</th>

                <td>
                    <?= htmlspecialchars(
                        $case['title'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>العميل</th>

                <td>
                    <?= htmlspecialchars(
                        $case['client_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>المحامي</th>

                <td>
                    <?= htmlspecialchars(
                        $case['lawyer_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>نوع القضية</th>

                <td>
                    <?= htmlspecialchars(
                        $case['case_type_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>المحكمة</th>

                <td>
                    <?= htmlspecialchars(
                        $case['court_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>رقم الدائرة</th>

                <td>
                    <?= htmlspecialchars(
                        $case['court_number'] ?? '—',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>الحالة</th>

                <td>
                    <?= htmlspecialchars(
                        $statusLabels[$case['status']]
                            ?? $case['status'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>تاريخ القيد</th>

                <td>
                    <?= htmlspecialchars(
                        $case['filing_date'] ?? '—',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>الوصف</th>

                <td class="description">

                    <?= nl2br(
                        htmlspecialchars(
                            $case['description'] ?? '—',
                            ENT_QUOTES,
                            'UTF-8'
                        )
                    ) ?>

                </td>

            </tr>

        </table>

    </section>


    <!-- Status History -->

    <section class="section">

        <h2>سجل حالات القضية</h2>

        <?php if (empty($statusHistory)): ?>

            <div class="empty">
                لا يوجد سجل لحالات القضية.
            </div>

        <?php else: ?>

            <table class="history">

                <thead>

                    <tr>
                        <th>الحالة السابقة</th>
                        <th>الحالة الجديدة</th>
                        <th>بواسطة</th>
                        <th>التاريخ</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($statusHistory as $history): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $oldStatusLabel(
                                    $history['old_status'] ?? null
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td class="status-change">
                            <?= htmlspecialchars(
                                $oldStatusLabel(
                                    $history['new_status'] ?? null
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $history['changed_by_name'] ?? '—',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $history['changed_at'] ?? '—',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        <?php endif; ?>

    </section>


    <!-- Hearings -->

    <section class="section">

        <h2>جلسات القضية</h2>

    <a href="?route=hearings/create&case_id=<?= (int) $case['id'] ?>" class="edit-btn">
        إضافة جلسة
    </a>

        <?php if (empty($hearings)): ?>

            <div class="empty">
                لا توجد جلسات لهذه القضية.
            </div>

        <?php else: ?>

            <table class="hearings">

                <thead>

                    <tr>
                        <th>التاريخ</th>
                        <th>الوقت</th>
                        <th>المحكمة</th>
                        <th>رقم الدائرة</th>
                        <th>نوع الجلسة</th>
                        <th>الحالة</th>
                        <th>الملاحظات</th>
                        <th>تعديل</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($hearings as $hearing): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $hearing['hearing_date'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $hearing['hearing_time'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $hearing['court_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $hearing['court_number'] ?? '—',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $hearing['hearing_type'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td class="hearing-status">

                            <?= htmlspecialchars(
                                $hearingStatusLabels[
                                    $hearing['status']
                                ] ?? $hearing['status'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </td>

                        <td>

                            <?php if (!empty($hearing['notes'])): ?>

                                <?= nl2br(
                                    htmlspecialchars(
                                        $hearing['notes'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                ) ?>

                            <?php else: ?>

                                —

                            <?php endif; ?>

                        </td>

                        <td>
                            <a href="?route=hearings/edit&id=<?= (int) $hearing['id'] ?>"  class="edit-btn" >
                                تعديل           
                            </a>
                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        <?php endif; ?>

    </section>


    <!-- Actions -->

    <section class="actions">

        <a
            href="?route=cases/edit&id=<?= (int) $case['id'] ?>"
            class="edit-btn"
        >
            تعديل القضية
        </a>

        <a
            href="?route=cases"
            class="btn"
        >
            العودة إلى القضايا
        </a>

    </section>


</div>

</body>

</html>