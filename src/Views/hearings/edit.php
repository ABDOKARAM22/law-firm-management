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

$values = [
    'hearing_date' => $old['hearing_date'] ?? $hearing['hearing_date'],
    'hearing_time' => $old['hearing_time'] ?? $hearing['hearing_time'],
    'court_name' => $old['court_name'] ?? $hearing['court_name'],
    'court_number' => $old['court_number'] ?? ($hearing['court_number'] ?? ''),
    'hearing_type' => $old['hearing_type'] ?? $hearing['hearing_type'],
    'status' => $old['status'] ?? $hearing['status'],
    'notes' => $old['notes'] ?? ($hearing['notes'] ?? ''),
];
?>

<style>
    .hearing-page {
        max-width: 850px;
        margin: 40px auto;
        padding: 0 20px;
        direction: rtl;
        font-family: Arial, sans-serif;
    }

    .hearing-page h1 {
        margin-bottom: 10px;
        color: #222;
    }

    .case-info {
        background: #f5f7fa;
        border-right: 4px solid #3498db;
        padding: 15px 18px;
        margin-bottom: 25px;
        border-radius: 6px;
        color: #444;
    }

    .case-info strong {
        color: #222;
    }

    .error-box {
        background: #fff0f0;
        border: 1px solid #e0a0a0;
        color: #a33;
        padding: 12px 18px;
        margin-bottom: 25px;
        border-radius: 6px;
    }

    .error-box ul {
        margin: 0;
        padding-right: 20px;
    }

    .hearing-form {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-weight: bold;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 15px;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.12);
    }

    .form-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .field-error {
        display: block;
        margin-top: 6px;
        color: #c0392b;
        font-size: 13px;
    }

    .submit-btn {
        border: none;
        background: #3498db;
        color: white;
        padding: 11px 25px;
        border-radius: 5px;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .submit-btn:hover {
        background: #2980b9;
    }

    .back-link {
        display: inline-block;
        margin-top: 18px;
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="hearing-page">

    <h1>تعديل الجلسة</h1>

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
        action="?route=hearings/edit&id=<?= (int) $hearing['id'] ?>"
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
                value="<?= htmlspecialchars($values['hearing_date']) ?>"
            >

            <?php if (isset($errors['hearing_date'])): ?>
                <small class="field-error">
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
                value="<?= htmlspecialchars($values['hearing_time']) ?>"
            >

            <?php if (isset($errors['hearing_time'])): ?>
                <small class="field-error">
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
                value="<?= htmlspecialchars($values['court_name']) ?>"
            >

            <?php if (isset($errors['court_name'])): ?>
                <small class="field-error">
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
                value="<?= htmlspecialchars($values['court_number']) ?>"
            >
        </div>

        <div class="form-group">
            <label for="hearing_type">نوع الجلسة</label>

            <input
                type="text"
                id="hearing_type"
                name="hearing_type"
                value="<?= htmlspecialchars($values['hearing_type']) ?>"
            >

            <?php if (isset($errors['hearing_type'])): ?>
                <small class="field-error">
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
                        <?= $values['status'] === $value ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($label) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <?php if (isset($errors['status'])): ?>
                <small class="field-error">
                    <?= htmlspecialchars($errors['status']) ?>
                </small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="notes">ملاحظات</label>

            <textarea
                id="notes"
                name="notes"
            ><?= htmlspecialchars($values['notes']) ?></textarea>
        </div>

        <button type="submit" class="submit-btn">
            حفظ التعديلات
        </button>

    </form>

    <a
        class="back-link"
        href="?route=cases/show&id=<?= (int) $case['id'] ?>"
    >
        ← العودة للقضية
    </a>

</div>