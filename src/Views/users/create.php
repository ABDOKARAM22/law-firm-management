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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إضافة مستخدم</title>
</head>

<body>

<h1>إضافة مستخدم</h1>

<?php if ($error = Flash::get('error')): ?>

    <div>
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </div>

<?php endif; ?>


<form method="POST" action="?route=users/create">

    <input
        type="hidden"
        name="_token"
        value="<?= htmlspecialchars(
            Csrf::token(),
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
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
                $old['name'] ?? '',
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
                $old['email'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
            required
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


    <!-- Password -->

    <div>

        <label for="password">
            كلمة المرور
        </label>

        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <?php if (isset($errors['password'])): ?>

            <div>
                <?= htmlspecialchars(
                    $errors['password'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>

        <?php endif; ?>

    </div>


    <br>


    <!-- Role -->

    <div>

        <label for="role">
            الدور
        </label>

        <select id="role" name="role" required>

            <option
                value="admin"
                <?= ($old['role'] ?? '') === 'admin' ? 'selected' : '' ?>
            >
                Admin
            </option>

            <option
                value="lawyer"
                <?= ($old['role'] ?? '') === 'lawyer' ? 'selected' : '' ?>
            >
                Lawyer
            </option>

            <option
                value="staff"
                <?= ($old['role'] ?? '') === 'staff' ? 'selected' : '' ?>
            >
                Staff
            </option>

        </select>

        <?php if (isset($errors['role'])): ?>

            <div>
                <?= htmlspecialchars(
                    $errors['role'],
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

        <select id="status" name="status" required>

            <option
                value="active"
                <?= ($old['status'] ?? '') === 'active' ? 'selected' : '' ?>
            >
                Active
            </option>

            <option
                value="inactive"
                <?= ($old['status'] ?? '') === 'inactive' ? 'selected' : '' ?>
            >
                Inactive
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
        إضافة المستخدم
    </button>

</form>


<br>


<a href="?route=users">
    العودة للمستخدمين
</a>

</body>

</html>