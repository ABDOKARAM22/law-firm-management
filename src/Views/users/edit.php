<?php

use LawFirmManagement\Core\Flash;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

$name = $old['name'] ?? $user['name'];
$email = $old['email'] ?? $user['email'];
$role = $old['role'] ?? $user['role'];
$status = $old['status'] ?? $user['status'];

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>تعديل المستخدم</title>
</head>

<body>

    <h1>تعديل المستخدم</h1>

    <form method="POST" action="?route=users/edit">

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
            value="<?= (int) $user['id'] ?>"
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

        <!-- Role -->
        <div>

            <label for="role">
                الدور
            </label>

            <select
                id="role"
                name="role"
                required
            >

                <option
                    value="admin"
                    <?= $role === 'admin' ? 'selected' : '' ?>
                >
                    Admin
                </option>

                <option
                    value="lawyer"
                    <?= $role === 'lawyer' ? 'selected' : '' ?>
                >
                    Lawyer
                </option>

                <option
                    value="staff"
                    <?= $role === 'staff' ? 'selected' : '' ?>
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

            <select
                id="status"
                name="status"
                required
            >

                <option
                    value="active"
                    <?= $status === 'active' ? 'selected' : '' ?>
                >
                    Active
                </option>

                <option
                    value="inactive"
                    <?= $status === 'inactive' ? 'selected' : '' ?>
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
            حفظ التعديلات
        </button>

    </form>

    <br>

    <a href="?route=users">
        العودة للمستخدمين
    </a>

</body>

</html>