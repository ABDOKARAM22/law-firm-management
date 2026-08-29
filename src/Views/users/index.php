<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>المستخدمون</title>
</head>


    <?php

    use LawFirmManagement\Core\Flash;

    $success = Flash::get('success');
    ?>

    <?php if ($success): ?>
        <div>
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>



<body>

    <h1>المستخدمون</h1>

    <a href="?route=users/create">
    إضافة مستخدم
    </a>

    <br>

    <a href="?route=dashboard">
        العودة للوحة التحكم
    </a>
    
    <hr>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الدور</th>
                <th>الحالة</th>
                <th>تاريخ الإنشاء</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($users as $user): ?>

            <tr>
                <td>
                    <?= (int) $user['id'] ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $user['name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $user['email'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $user['role'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $user['status'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $user['created_at'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>

</body>
</html>