<?php

use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;

$errors = Flash::get('errors') ?? [];
$success = Flash::get('success');

?>

<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>مستندات القضية</title>

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
            max-width: 1200px;
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

        .success-message {
            margin-bottom: 20px;
            padding: 12px 15px;
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
            border-radius: 6px;
            text-align: center;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 10px;
        }

        .add-link {
            display: inline-block;
            padding: 10px 18px;
            background: #1f6f8b;
            color: #ffffff;
            border-radius: 6px;
            text-decoration: none;
        }

        .add-link:hover {
            background: #15566d;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th {
            background: #1f3c5b;
            color: #ffffff;
            padding: 13px 12px;
            text-align: center;
            font-size: 14px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e1e5e9;
            text-align: center;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .actions {
            white-space: nowrap;
        }

        .actions a {
            display: inline-block;
            margin: 2px;
            padding: 7px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
        }

        .download-link {
            background: #1f6f8b;
            color: #ffffff;
        }

        .download-link:hover {
            background: #15566d;
        }

        .edit-link {
            background: #d68910;
            color: #ffffff;
        }

        .edit-link:hover {
            background: #b9770e;
        }

        .delete-form {
            display: inline;
        }

        .delete-button {
            border: none;
            padding: 7px 10px;
            border-radius: 5px;
            background: #c0392b;
            color: #ffffff;
            font-size: 13px;
            cursor: pointer;
        }

        .delete-button:hover {
            background: #962d22;
        }

        .empty-message {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 8px;
            color: #666;
        }

        .bottom-actions {
            display: flex;
            justify-content: flex-start;
            margin-top: 25px;
        }

        .back-link {
            display: inline-block;
            padding: 10px 18px;
            background: #1f3c5b;
            color: #ffffff;
            border-radius: 6px;
            text-decoration: none;
        }

        .back-link:hover {
            background: #162d43;
        }

        @media (max-width: 600px) {

            body {
                padding: 20px 10px;
            }

            .container {
                padding: 20px;
            }

            .top-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .add-link {
                text-align: center;
            }

            .bottom-actions {
                justify-content: stretch;
            }

            .back-link {
                width: 100%;
                text-align: center;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <h1>مستندات القضية</h1>

    <?php if ($success): ?>

        <div class="success-message">
            <?= htmlspecialchars($success) ?>
        </div>

    <?php endif; ?>

    <div class="top-actions">

        <a
            class="add-link"
            href="?route=documents/create&case_id=<?= (int) $caseId ?>"
        >
            + إضافة مستند
        </a>

    </div>

    <?php if (!empty($documents)): ?>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>العنوان</th>
                        <th>اسم الملف</th>
                        <th>نوع الملف</th>
                        <th>حجم الملف</th>
                        <th>تم الرفع بواسطة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($documents as $document): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($document['title']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($document['file_name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($document['file_type']) ?>
                        </td>

                        <td>
                            <?= number_format($document['file_size'] / 1024, 2) ?>
                            KB
                        </td>

                        <td>
                            <?= htmlspecialchars($document['uploaded_by_name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($document['created_at']) ?>
                        </td>

                        <td class="actions">

                            <a
                                class="download-link"
                                href="?route=documents/download&id=<?= (int) $document['id'] ?>"
                            >
                                تحميل
                            </a>

                            <a
                                class="edit-link"
                                href="?route=documents/edit&id=<?= (int) $document['id'] ?>"
                            >
                                تعديل
                            </a>

                            <form
                                class="delete-form"
                                method="POST"
                                action="?route=documents/delete&id=<?= (int) $document['id'] ?>"
                            >

                                <input
                                    type="hidden"
                                    name="_token"
                                    value="<?= htmlspecialchars(Csrf::token()) ?>"
                                >

                                <button
                                    class="delete-button"
                                    type="submit"
                                >
                                    حذف
                                </button>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php else: ?>

        <p class="empty-message">
            لا توجد مستندات لهذه القضية.
        </p>

    <?php endif; ?>

    <div class="bottom-actions">

        <a
            class="back-link"
            href="?route=cases/show&id=<?= (int) $caseId ?>"
        >
            العودة إلى القضية
        </a>

    </div>

</div>

</body>

</html>