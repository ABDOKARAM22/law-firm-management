<?php

use LawFirmManagement\Core\Flash;

$success = Flash::get('success');
$errors = Flash::get('errors');

?>

<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <title>القضايا</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #333;
            color: white;
            border-radius: 5px;
        }

        .edit-btn {
            display: inline-block;
            padding: 7px 12px;
            background: #007bff;
            color: white;
            border-radius: 5px;
        }

        .success {
            padding: 10px;
            background: #d4edda;
            color: #155724;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .filters {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .filters div {
            margin-bottom: 10px;
        }

        .filters input,
        .filters select {
            padding: 8px;
            margin-right: 5px;
        }

        .filters button {
            padding: 8px 15px;
            cursor: pointer;
        }

        .clear-btn {
            display: inline-block;
            padding: 8px 15px;
            margin-right: 5px;
            background: #777;
            color: white;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: right;
        }

        th {
            background: #eee;
        }

        .empty {
            text-align: center;
            padding: 30px;
            background: white;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 2px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
        }

        .pagination .active {
            background: #333;
            color: white;
        }

        .pagination .disabled {
            color: #aaa;
        }
    </style>

</head>

<body>

<div class="container">

    <div class="header">

        <h1>القضايا</h1>

        <a href="?route=cases/create" class="btn">
            إضافة قضية
        </a>

    </div>


    <?php if ($success): ?>

        <div class="success">
            <?= htmlspecialchars($success) ?>
        </div>

    <?php endif; ?>


    <!-- Search & Filters -->

    <form method="GET" action="" class="filters">

        <input
            type="hidden"
            name="route"
            value="cases"
        >

        <div>

            <label for="search">
                بحث:
            </label>

            <input
                type="text"
                id="search"
                name="search"
                value="<?= htmlspecialchars($search) ?>"
                placeholder="رقم القضية أو اسم العميل أو المحامي"
            >

        </div>


        <div>

            <label for="status">
                الحالة:
            </label>

            <select
                name="status"
                id="status"
            >

                <option value="">
                    كل الحالات
                </option>

                <?php foreach ($allowedStatuses as $allowedStatus): ?>

                    <option
                        value="<?= htmlspecialchars($allowedStatus) ?>"
                        <?= $status === $allowedStatus ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($allowedStatus) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div>

            <label for="case_type_id">
                نوع القضية:
            </label>

            <select
                name="case_type_id"
                id="case_type_id"
            >

                <option value="">
                    كل الأنواع
                </option>

                <?php foreach ($caseTypes as $caseType): ?>

                    <option
                        value="<?= (int) $caseType['id'] ?>"
                        <?= $caseTypeId === (int) $caseType['id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($caseType['name']) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div>

            <label for="lawyer_id">
                المحامي:
            </label>

            <select
                name="lawyer_id"
                id="lawyer_id"
            >

                <option value="">
                    كل المحامين
                </option>

                <?php foreach ($lawyers as $lawyer): ?>

                    <option
                        value="<?= (int) $lawyer['id'] ?>"
                        <?= $lawyerId === (int) $lawyer['id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($lawyer['name']) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <button type="submit">
            بحث
        </button>


        <a
            href="?route=cases"
            class="clear-btn"
        >
            مسح الفلاتر
        </a>

    </form>


    <?php if (empty($cases)): ?>

        <div class="empty">

            لا توجد قضايا مطابقة للبحث.

        </div>

    <?php else: ?>


        <table>

            <thead>

                <tr>

                    <th>#</th>

                    <th>رقم القضية</th>

                    <th>عنوان القضية</th>

                    <th>العميل</th>

                    <th>المحامي</th>

                    <th>نوع القضية</th>

                    <th>المحكمة</th>

                    <th>الحالة</th>

                    <th>تاريخ القيد</th>

                    <th>الإجراءات</th>

                </tr>

            </thead>


            <tbody>

            <?php foreach ($cases as $case): ?>

                <tr>

                    <td>
                        <?= (int) $case['id'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['case_number']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['title']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['client_name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['lawyer_name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['case_type_name']) ?>
                    </td>

                    <td>

                        <?= htmlspecialchars($case['court_name']) ?>

                        <?php if (!empty($case['court_number'])): ?>

                            -
                            <?= htmlspecialchars($case['court_number']) ?>

                        <?php endif; ?>

                    </td>

                    <td>
                        <?= htmlspecialchars($case['status']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($case['filing_date'] ?? '') ?>
                    </td>

                    <td>

                        <a
                            href="?route=cases/edit&id=<?= (int) $case['id'] ?>"
                            class="edit-btn"
                        >
                            تعديل
                        </a>

                        <a
                            href="?route=cases/show&id=<?= (int) $case['id'] ?>"
                            class="edit-btn"
                        >
                            عرض
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>


        <!-- Pagination -->

        <?php if ($totalPages > 1): ?>

            <div class="pagination">

                <?php

                $paginationParams = [
                    'route' => 'cases',
                    'search' => $search,
                    'status' => $status,
                    'case_type_id' => $caseTypeId,
                    'lawyer_id' => $lawyerId,
                ];

                ?>


                <?php if ($page > 1): ?>

                    <?php
                    $paginationParams['page'] = $page - 1;
                    ?>

                    <a
                        href="?<?= htmlspecialchars(http_build_query($paginationParams)) ?>"
                    >
                        السابق
                    </a>

                <?php else: ?>

                    <span class="disabled">
                        السابق
                    </span>

                <?php endif; ?>


                <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                    <?php
                    $paginationParams['page'] = $i;
                    ?>

                    <?php if ($i === $page): ?>

                        <span class="active">
                            <?= $i ?>
                        </span>

                    <?php else: ?>

                        <a
                            href="?<?= htmlspecialchars(http_build_query($paginationParams)) ?>"
                        >
                            <?= $i ?>
                        </a>

                    <?php endif; ?>

                <?php endfor; ?>


                <?php if ($page < $totalPages): ?>

                    <?php
                    $paginationParams['page'] = $page + 1;
                    ?>

                    <a
                        href="?<?= htmlspecialchars(http_build_query($paginationParams)) ?>"
                    >
                        التالي
                    </a>

                <?php else: ?>

                    <span class="disabled">
                        التالي
                    </span>

                <?php endif; ?>

            </div>

        <?php endif; ?>


    <?php endif; ?>


</div>

</body>

</html>