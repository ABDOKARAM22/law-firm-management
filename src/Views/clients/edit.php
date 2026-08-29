<?php

use LawFirmManagement\Core\Flash;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

$name = $old['name'] ?? $client['name'];
$nationalId = $old['national_id'] ?? $client['national_id'];
$phone = $old['phone'] ?? $client['phone'];
$email = $old['email'] ?? ($client['email'] ?? '');
$address = $old['address'] ?? ($client['address'] ?? '');
$status = $old['status'] ?? $client['status'];

?>

<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>تعديل العميل</title>

</head>

<body>

<h1>تعديل العميل</h1>

<form method="POST" action="?route=clients/edit">

    <input
        type="hidden"
        name="_token"
        value="<?= htmlspecialchars(
            LawFirmManagement\Core\Csrf::token(),
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
    >

    <input
        type="hidden"
        name="id"
        value="<?= (int) $client['id'] ?>"
    >

    <!-- Name -->
    <div>

        <label for="name">
            الاسم
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="<?= htmlspecialchars(
                $name,
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
            required
        >

        <?php if (isset($errors['name'])): ?>

            <div>
                <?= htmlspecialchars(
                    $errors['name'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>

        <?php endif; ?>

    </div>

    <br>

    <!-- National ID -->
    <div>

        <label for="national_id">
            الرقم القومي
        </label>

        <input
            type="text"
            id="national_id"
            name="national_id"
            value="<?= htmlspecialchars(
                $nationalId,
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
            required
        >

        <?php if (isset($errors['national_id'])): ?>

            <div>
                <?= htmlspecialchars(
                    $errors['national_id'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>

        <?php endif; ?>

    </div>

    <br>

    <!-- Phone -->
    <div>

        <label for="phone">
            رقم الهاتف
        </label>

        <input
            type="text"
            id="phone"
            name="phone"
            value="<?= htmlspecialchars(
                $phone,
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
            required
        >

        <?php if (isset($errors['phone'])): ?>

            <div>
                <?= htmlspecialchars(
                    $errors['phone'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>

        <?php endif; ?>

    </div>

    <br>

    <!-- Email -->
    <div>

        <label for="email">
            البريد الإلكتروني
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars(
                $email,
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >

        <?php if (isset($errors['email'])): ?>

            <div>
                <?= htmlspecialchars(
                    $errors['email'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>

        <?php endif; ?>

    </div>

    <br>

    <!-- Address -->
    <div>

        <label for="address">
            العنوان
        </label>

        <textarea
            id="address"
            name="address"
            rows="4"
        ><?= htmlspecialchars(
            $address,
            ENT_QUOTES,
            'UTF-8'
        ) ?></textarea>

        <?php if (isset($errors['address'])): ?>

            <div>
                <?= htmlspecialchars(
                    $errors['address'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>

        <?php endif; ?>

    </div>

    <br>

    <!-- Status -->
    <div>

        <label for="status">
            الحالة
        </label>

        <select
            id="status"
            name="status"
            required
        >

            <option
                value="active"
                <?= $status === 'active' ? 'selected' : '' ?>
            >
                نشط
            </option>

            <option
                value="inactive"
                <?= $status === 'inactive' ? 'selected' : '' ?>
            >
                غير نشط
            </option>

        </select>

        <?php if (isset($errors['status'])): ?>

            <div>
                <?= htmlspecialchars(
                    $errors['status'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>

        <?php endif; ?>

    </div>

    <br>

    <button type="submit">
        حفظ التعديلات
    </button>

</form>

<br>

<a href="?route=clients">
    العودة للعملاء
</a>

</body>

</html>