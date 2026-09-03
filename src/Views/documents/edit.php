<?php

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;

$errors = Flash::get('errors') ?? [];
$old = Flash::get('old') ?? [];

?>

<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>تعديل مستند</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            background: #f5f6fa;
            font-family: Arial, sans-serif;
            color: #2c3e50;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
            color: #1f3c5b;
            font-size: 28px;
        }

        .case-info {
            background: #f0f4f8;
            padding: 15px 18px;
            border-radius: 8px;
            margin-bottom: 25px;
            line-height: 1.8;
        }

        .file-info {
            background: #fafafa;
            border: 1px solid #e1e5e9;
            padding: 18px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .file-info p {
            margin: 8px 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #ccd3da;
            border-radius: 6px;
            font-size: 15px;
            background: #fff;
        }

        input[type="text"]:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.12);
        }

        .error {
            margin-top: 7px;
            color: #c0392b;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #1f6f8b;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #15566d;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #1f6f8b;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>تعديل مستند</h1>

    <div class="case-info">
        القضية:
        <?= htmlspecialchars($document['case_number']) ?>
        -
        <?= htmlspecialchars($document['case_title']) ?>
    </div>

    <div class="file-info">

        <p>
            <strong>الملف الحالي:</strong>
            <?= htmlspecialchars($document['file_name']) ?>
        </p>

        <p>
            <strong>نوع الملف:</strong>
            <?= htmlspecialchars($document['file_type']) ?>
        </p>

        <p>
            <strong>حجم الملف:</strong>
            <?= round($document['file_size'] / 1024, 2) ?> KB
        </p>

    </div>

    <form
        method="POST"
        action="?route=documents/edit&id=<?= (int) $document['id'] ?>"
        enctype="multipart/form-data"
    >

        <input
            type="hidden"
            name="_token"
            value="<?= htmlspecialchars(Csrf::token()) ?>"
        >

        <div class="form-group">

            <label for="title">
                عنوان المستند
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="<?= htmlspecialchars(
                    $old['title'] ?? $document['title']
                ) ?>"
            >

            <?php if (isset($errors['title'])): ?>

                <p class="error">
                    <?= htmlspecialchars($errors['title']) ?>
                </p>

            <?php endif; ?>

        </div>

        <div class="form-group">

            <label for="file">
                استبدال الملف (اختياري)
            </label>

            <input
                type="file"
                id="file"
                name="file"
            >

            <?php if (isset($errors['file'])): ?>

                <p class="error">
                    <?= htmlspecialchars($errors['file']) ?>
                </p>

            <?php endif; ?>

        </div>

        <button type="submit">
            حفظ التعديلات
        </button>

    </form>

    <a
        class="back-link"
        href="?route=cases/documents&id=<?= (int) $document['case_id'] ?>"
    >
        العودة إلى مستندات القضية
    </a>

</div>

</body>

</html>