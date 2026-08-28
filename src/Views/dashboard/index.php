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