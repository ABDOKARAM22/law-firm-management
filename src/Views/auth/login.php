<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - Law Firm Management</title>
</head>

<body>

    <main>
        <h1>نظام إدارة مكتب المحاماة</h1>

        <h2>تسجيل الدخول</h2>

        <form method="POST" action="?route=login">
            <div>
                <label for="email">البريد الإلكتروني</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                >
            </div>

            <div>
                <label for="password">كلمة المرور</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <button type="submit">تسجيل الدخول</button>
        </form>
    </main>

</body>
</html>