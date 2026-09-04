<!DOCTYPE html>

<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
</head>

<body>

<?php

use LawFirmManagement\Core\Flash;

$success = Flash::get('success');
?>

<?php if ($success): ?>
    <div>
        <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>


<h1>لوحة التحكم</h1>

<p>
    مرحبًا،
    <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>
</p>

<p>
    Role:
    <?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?>
</p>


<?php if ($user['role'] === 'admin'): ?>

    <!-- Admin Statistics -->

    <div class="dashboard-stats">

        <div class="stat-card">
            <h3>إجمالي العملاء</h3>
            <p><?= (int) $stats['clients_count'] ?></p>
        </div>

        <div class="stat-card">
            <h3>إجمالي القضايا</h3>
            <p><?= (int) $stats['cases_count'] ?></p>
        </div>

        <div class="stat-card">
            <h3>إجمالي المحامين</h3>
            <p><?= (int) $stats['lawyers_count'] ?></p>
        </div>

        <div class="stat-card">
            <h3>إجمالي الموظفين</h3>
            <p><?= (int) $stats['staff_count'] ?></p>
        </div>

    </div>


<?php elseif ($user['role'] === 'staff'): ?>

    <!-- Staff Statistics -->

    <div class="dashboard-stats">

        <div class="stat-card">
            <h3>إجمالي العملاء</h3>
            <p><?= (int) $stats['clients_count'] ?></p>
        </div>

        <div class="stat-card">
            <h3>إجمالي القضايا</h3>
            <p><?= (int) $stats['cases_count'] ?></p>
        </div>

    </div>


<?php elseif ($user['role'] === 'lawyer'): ?>

    <!-- Lawyer Statistics -->

    <div class="dashboard-stats">

        <div class="stat-card">
            <h3>القضايا المسندة إليك</h3>
            <p><?= (int) $stats['cases_count'] ?></p>
        </div>

    </div>

<?php endif; ?>


<?php if (in_array($user['role'], ['admin', 'staff', 'lawyer'], true)): ?>

    <!-- Cases Status -->

    <div class="case-status-section">

        <h2>حالات القضايا</h2>

        <div class="case-status-list">

            <div class="status-card">
                <span>قيد الانتظار</span>
                <strong><?= (int) $stats['cases_by_status']['pending'] ?></strong>
            </div>

            <div class="status-card">
                <span>نشطة</span>
                <strong><?= (int) $stats['cases_by_status']['active'] ?></strong>
            </div>

            <div class="status-card">
                <span>موقوفة مؤقتًا</span>
                <strong><?= (int) $stats['cases_by_status']['on_hold'] ?></strong>
            </div>

            <div class="status-card">
                <span>مغلقة</span>
                <strong><?= (int) $stats['cases_by_status']['closed'] ?></strong>
            </div>

        </div>

    </div>

<?php endif; ?>



<?php if (!empty($stats['upcoming_appointments'])): ?>

    <div class="upcoming-section">

        <h2>المواعيد القادمة</h2>

        <div class="appointments-list">

            <?php foreach ($stats['upcoming_appointments'] as $appointment): ?>

                <div class="appointment-card">

                    <h3>
                        <?= htmlspecialchars(
                            $appointment['title'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </h3>

                    <p>
                        التاريخ:
                        <?= htmlspecialchars(
                            $appointment['appointment_date'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                    <p>
                        الوقت:
                        <?= htmlspecialchars(
                            $appointment['appointment_time'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                    <?php if (!empty($appointment['client_name'])): ?>

                        <p>
                            العميل:
                            <?= htmlspecialchars(
                                $appointment['client_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                    <?php endif; ?>

                    <?php if ($user['role'] !== 'lawyer'): ?>

                        <p>
                            المسؤول:
                            <?= htmlspecialchars(
                                $appointment['assigned_user_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

<?php endif; ?>





<?php if (!empty($stats['upcoming_hearings'])): ?>

    <div class="upcoming-section">

        <h2>الجلسات القادمة</h2>

        <div class="hearings-list">

            <?php foreach ($stats['upcoming_hearings'] as $hearing): ?>

                <div class="hearing-card">

                    <h3>
                        قضية:
                        <?= htmlspecialchars(
                            $hearing['case_number'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </h3>

                    <p>
                        العميل:
                        <?= htmlspecialchars(
                            $hearing['client_name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                    <p>
                        التاريخ:
                        <?= htmlspecialchars(
                            $hearing['hearing_date'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                    <p>
                        الوقت:
                        <?= htmlspecialchars(
                            $hearing['hearing_time'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                    <p>
                        المحكمة:
                        <?= htmlspecialchars(
                            $hearing['court_name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                    <?php if (!empty($hearing['court_number'])): ?>

                        <p>
                            الدائرة:
                            <?= htmlspecialchars(
                                $hearing['court_number'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                    <?php endif; ?>


                        <p>
                            الحالة:
                            <?php
                            $hearingStatusLabels = [
                                'scheduled' => 'مجدولة',
                                'completed' => 'مكتملة',
                                'cancelled' => 'ملغاة',
                            ];
                            ?>

                            <?= htmlspecialchars(
                                $hearingStatusLabels[$hearing['status']] ?? $hearing['status'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

<?php endif; ?>



<form method="POST" action="?route=logout">

    <input
        type="hidden"
        name="_token"
        value="<?= htmlspecialchars(
            \LawFirmManagement\Core\Csrf::token(),
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
    >

    <button type="submit">
        تسجيل الخروج
    </button>

</form>

</body>
</html>