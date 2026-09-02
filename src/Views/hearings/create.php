<?php

use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\Csrf;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

$statusLabels = [
    'scheduled' => 'مجدولة',
    'completed' => 'منعقدة',
    'postponed' => 'مؤجلة',
    'cancelled' => 'ملغاة',
];
?>

<style>
    .hearing-page {
        max-width: 800px;
        margin: 30px auto;
    }

    .hearing-page h1 {
        margin-bottom: 10px;
    }

    .case-info {
        background: #f5f5f5;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 6px;
    }

    .hearing-form {
        background: #fff;
        padding: 25px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 15px;
    }

    .form-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .error {
        display: block;
        margin-top: 5px;
        color: #c62828;
        font-size: 14px;
    }

    .errors-box {
        background: #ffecec;
        border: 1px solid #e57373;
        color: #b71c1c;
        padding: 12px 20px;
        margin-bottom: 20px;
        border-radius: 6px;
    }

    .errors-box ul {
        margin: 0;
        padding-right: 20px;
    }

    .form-actions {
        margin-top: 25px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn {
        display: inline-block;
        padding: 10px 18px;
        border-radius: 5px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 15px;
    }

    .btn-primary {
        background: #333;
        color: #fff;
    }

    .btn-secondary {
        background: #eee;
        color: #333;
    }
</style>

<div class="hearing-page">

    <h1>إضافة جلسة</h1>

    <div class="case-info">
        القضية:
        <strong>
            <?= htmlspecialchars($case['case_number']) ?>
            -
            <?= htmlspecialchars($case['title']) ?>
        </strong>
    </div>


    <form
        class="hearing-form"
        method="POST"
        action="?route=hearings/create&case_id=<?= (int) $case['id'] ?>"
    >

        <input
            type="hidden"
            name="_token"
            value="<?= htmlspecialchars(Csrf::token()) ?>"
        >

        <div class="form-group">
            <label for="hearing_date">تاريخ الجلسة</label>

            <input
                type="date"
                id="hearing_date"
                name="hearing_date"
                value="<?= htmlspecialchars($old['hearing_date'] ?? '') ?>"
            >

            <?php if (isset($errors['hearing_date'])): ?>
                <small class="error">
                    <?= htmlspecialchars($errors['hearing_date']) ?>
                </small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="hearing_time">وقت الجلسة</label>

            <input
                type="time"
                id="hearing_time"
                name="hearing_time"
                value="<?= htmlspecialchars($old['hearing_time'] ?? '') ?>"
            >

            <?php if (isset($errors['hearing_time'])): ?>
                <small class="error">
                    <?= htmlspecialchars($errors['hearing_time']) ?>
                </small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="court_name">اسم المحكمة</label>

            <input
                type="text"
                id="court_name"
                name="court_name"
                value="<?= htmlspecialchars(
                    $old['court_name'] ?? $case['court_name'] ?? ''
                ) ?>"
            >

            <?php if (isset($errors['court_name'])): ?>
                <small class="error">
                    <?= htmlspecialchars($errors['court_name']) ?>
                </small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="court_number">رقم الدائرة</label>

            <input
                type="text"
                id="court_number"
                name="court_number"
                value="<?= htmlspecialchars(
                    $old['court_number'] ?? $case['court_number'] ?? ''
                ) ?>"
            >
        </div>

        <div class="form-group">
            <label for="hearing_type">نوع الجلسة</label>

            <input
                type="text"
                id="hearing_type"
                name="hearing_type"
                value="<?= htmlspecialchars($old['hearing_type'] ?? '') ?>"
            >

            <?php if (isset($errors['hearing_type'])): ?>
                <small class="error">
                    <?= htmlspecialchars($errors['hearing_type']) ?>
                </small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="status">الحالة</label>

            <select id="status" name="status">

                <?php foreach ($statusLabels as $value => $label): ?>

                    <option
                        value="<?= htmlspecialchars($value) ?>"
                        <?= ($old['status'] ?? 'scheduled') === $value
                            ? 'selected'
                            : '' ?>
                    >
                        <?= htmlspecialchars($label) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <?php if (isset($errors['status'])): ?>
                <small class="error">
                    <?= htmlspecialchars($errors['status']) ?>
                </small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="notes">ملاحظات</label>

            <textarea
                id="notes"
                name="notes"
            ><?= htmlspecialchars($old['notes'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">

            <button type="submit" class="btn btn-primary">
                إضافة الجلسة
            </button>

            <a
                href="?route=cases/show&id=<?= (int) $case['id'] ?>"
                class="btn btn-secondary"
            >
                العودة للقضية
            </a>

        </div>

    </form>

</div>