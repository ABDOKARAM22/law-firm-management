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

    <title>إضافة مستند</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            background: #f5f7fa;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 26px;
        }

        .case-info {
            background: #f1f5f9;
            border-right: 4px solid #2563eb;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 6px;
        }

        .case-info strong {
            color: #2563eb;
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
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 15px;
            background: #fff;
        }

        input[type="text"]:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #2563eb;
        }

        .error {
            margin-top: 7px;
            color: #dc2626;
            font-size: 14px;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 25px;
        }

        button {
            border: none;
            background: #2563eb;
            color: white;
            padding: 11px 22px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #1d4ed8;
        }

        .back-link {
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>إضافة مستند</h1>

        <div class="case-info">
            القضية:
            <strong>
                <?= htmlspecialchars($case['case_number']) ?>
            </strong>

            -
            
            <?= htmlspecialchars($case['title']) ?>
        </div>

        <form
            method="POST"
            action="?route=documents/create&case_id=<?= (int) $case['id'] ?>"
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
                    value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                    placeholder="مثال: عقد توكيل"
                >

                <?php if (isset($errors['title'])): ?>

                    <div class="error">
                        <?= htmlspecialchars($errors['title']) ?>
                    </div>

                <?php endif; ?>

            </div>

            <div class="form-group">

                <label for="file">
                    الملف
                </label>

                <input
                    type="file"
                    id="file"
                    name="file"
                >

                <?php if (isset($errors['file'])): ?>

                    <div class="error">
                        <?= htmlspecialchars($errors['file']) ?>
                    </div>

                <?php endif; ?>

            </div>

            <div class="actions">

                <button type="submit">
                    رفع المستند
                </button>

                <a
                    class="back-link"
                    href="?route=cases/documents&id=<?= (int) $case['id'] ?>"
                >
                    العودة إلى مستندات القضية
                </a>

            </div>

        </form>

    </div>

</div>

</body>

</html>