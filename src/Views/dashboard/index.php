<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
</head>

<body>

    <h1>لوحة التحكم</h1>

    <p>
        مرحبًا،
        <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>
    </p>

    <p>
        Role:
        <?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?>
    </p>

    <a href="?route=logout">تسجيل الخروج</a>

</body>
</html>