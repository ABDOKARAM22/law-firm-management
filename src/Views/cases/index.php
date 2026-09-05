<?php

use LawFirmManagement\Core\Flash;

$search = $search ?? '';
$status = $status ?? null;
$caseTypeId = $caseTypeId ?? null;
$lawyerId = $lawyerId ?? null;
$page = $page ?? 1;
$totalPages = $totalPages ?? 1;

$statusLabels = [
    'pending' => 'قيد الانتظار',
    'active' => 'نشطة',
    'on_hold' => 'معلقة',
    'closed' => 'مغلقة',
    'cancelled' => 'ملغاة',
];

$statusClasses = [
    'pending' => 'bg-yellow-lt text-yellow',
    'active' => 'bg-green-lt text-green',
    'on_hold' => 'bg-orange-lt text-orange',
    'closed' => 'bg-blue-lt text-blue',
    'cancelled' => 'bg-red-lt text-red',
];

$successMessage = Flash::get('success');

$paginationParams = [
    'route' => 'cases',
    'search' => $search,
    'status' => $status,
    'case_type_id' => $caseTypeId,
    'lawyer_id' => $lawyerId,
];

$pageTitle = 'القضايا';

require __DIR__ . '/../layouts/header.php';

?>

<div class="container-xl">

    <!-- Page Header -->
    <div class="page-header d-print-none mb-3">

        <div class="row align-items-center">

            <div class="col">

                <div class="page-pretitle">
                    إدارة القضايا
                </div>

                <h2 class="page-title">
                    القضايا
                </h2>

            </div>

            <?php if ($currentUser['role'] === 'admin'): ?>

                <div class="col-auto ms-auto">

                    <a
                        href="?route=cases/create"
                        class="btn btn-primary"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon"
                        >
                            <path d="M12 5v14"></path>
                            <path d="M5 12h14"></path>
                        </svg>

                        إضافة قضية
                    </a>

                </div>

            <?php endif; ?>

        </div>

    </div>


    <!-- Success Message -->
    <?php if ($successMessage): ?>

        <div
            class="alert alert-success alert-dismissible"
            role="alert"
        >

            <div>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="icon alert-icon"
                >
                    <path d="M5 12l5 5l10 -10"></path>
                </svg>

            </div>

            <div>
                <?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') ?>
            </div>

            <a
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="إغلاق"
            ></a>

        </div>

    <?php endif; ?>


    <!-- Filters -->
    <div class="card mb-3">

        <div class="card-body">

            <div class="row g-3 align-items-end">

                <!-- Search -->
                <div class="col-12 col-md-6 col-lg-4">

                    <label
                        for="search"
                        class="form-label"
                    >
                        البحث
                    </label>

                    <div class="input-icon">

                        <span class="input-icon-addon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon"
                            >
                                <circle
                                    cx="10"
                                    cy="10"
                                    r="7"
                                ></circle>

                                <path d="m21 21l-6 -6"></path>
                            </svg>

                        </span>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="form-control"
                            value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
                            placeholder="رقم القضية أو عنوانها..."
                            autocomplete="off"
                        >

                    </div>

                </div>


                <!-- Status -->
                <div class="col-12 col-md-6 col-lg-2">

                    <label
                        for="status"
                        class="form-label"
                    >
                        الحالة
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-select"
                    >

                        <option value="">
                            كل الحالات
                        </option>

                        <?php foreach ($statusLabels as $value => $label): ?>

                            <option
                                value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>"
                                <?= $status === $value ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Case Type -->
                <div class="col-12 col-md-6 col-lg-3">

                    <label
                        for="case_type_id"
                        class="form-label"
                    >
                        نوع القضية
                    </label>

                    <select
                        id="case_type_id"
                        name="case_type_id"
                        class="form-select"
                    >

                        <option value="">
                            كل الأنواع
                        </option>

                        <?php foreach ($caseTypes as $caseType): ?>

                            <option
                                value="<?= (int) $caseType['id'] ?>"
                                <?= (int) $caseTypeId === (int) $caseType['id'] ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars(
                                    $caseType['name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Lawyer -->
                <?php if ($currentUser['role'] !== 'lawyer'): ?>

                    <div class="col-12 col-md-6 col-lg-3">

                        <label
                            for="lawyer_id"
                            class="form-label"
                        >
                            المحامي
                        </label>

                        <select
                            id="lawyer_id"
                            name="lawyer_id"
                            class="form-select"
                        >

                            <option value="">
                                كل المحامين
                            </option>

                            <?php foreach ($lawyers as $lawyer): ?>

                                <option
                                    value="<?= (int) $lawyer['id'] ?>"
                                    <?= (int) $lawyerId === (int) $lawyer['id'] ? 'selected' : '' ?>
                                >
                                    <?= htmlspecialchars(
                                        $lawyer['name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>


    <!-- Cases Table -->
    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                قائمة القضايا
            </h3>

            <div class="card-actions">

                <span
                    id="cases-count"
                    class="text-secondary"
                >
                    <?= (int) $total ?> قضية
                </span>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table table-vcenter card-table">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            رقم القضية
                        </th>

                        <th>
                            عنوان القضية
                        </th>

                        <th>
                            العميل
                        </th>

                        <th>
                            المحامي
                        </th>

                        <th>
                            نوع القضية
                        </th>

                        <th>
                            المحكمة
                        </th>

                        <th>
                            الحالة
                        </th>

                        <th>
                            تاريخ القيد
                        </th>

                        <th class="text-end">
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <!--
                    هذا الـ tbody يجب أن يبقى موجودًا دائمًا
                    لأن AJAX يعتمد عليه.
                -->
                <tbody id="cases-table-body">

                    <?php if (empty($cases)): ?>

                        <tr>

                            <td
                                colspan="10"
                                class="text-center py-5"
                            >

                                <div class="empty">

                                    <div class="empty-icon">

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="icon"
                                        >
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                            <path d="M9 12h6"></path>
                                        </svg>

                                    </div>

                                    <p class="empty-title">
                                        لا توجد قضايا
                                    </p>

                                    <p class="empty-subtitle text-secondary">
                                        لا توجد قضايا مطابقة لمعايير البحث الحالية.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    <?php else: ?>

                        <?php foreach ($cases as $case): ?>

                            <tr>

                                <!-- ID -->
                                <td class="text-secondary">
                                    <?= (int) $case['id'] ?>
                                </td>


                                <!-- Case Number -->
                                <td>

                                    <span class="fw-semibold">

                                        <?= htmlspecialchars(
                                            $case['case_number'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Title -->
                                <td>

                                    <?= htmlspecialchars(
                                        $case['title'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </td>


                                <!-- Client -->
                                <td>

                                    <?= htmlspecialchars(
                                        $case['client_name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </td>


                                <!-- Lawyer -->
                                <td>

                                    <?= htmlspecialchars(
                                        $case['lawyer_name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </td>


                                <!-- Case Type -->
                                <td>

                                    <?= htmlspecialchars(
                                        $case['case_type_name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </td>


                                <!-- Court -->
                                <td>

                                    <div>

                                        <?= htmlspecialchars(
                                            $case['court_name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </div>

                                    <?php if (!empty($case['court_number'])): ?>

                                        <div class="text-secondary small">

                                            رقم:
                                            <?= htmlspecialchars(
                                                $case['court_number'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </div>

                                    <?php endif; ?>

                                </td>


                                <!-- Status -->
                                <td>

                                    <span
                                        class="badge <?= $statusClasses[$case['status']] ?? 'bg-secondary-lt text-secondary' ?>"
                                    >
                                        <?= htmlspecialchars(
                                            $statusLabels[$case['status']] ?? $case['status'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </span>

                                </td>


                                <!-- Filing Date -->
                                <td>

                                    <?= htmlspecialchars(
                                        $case['filing_date'] ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </td>


                                <!-- Actions -->
                                <td>

                                    <div class="btn-list justify-content-end">

                                        <a
                                            href="?route=cases/show&id=<?= (int) $case['id'] ?>"
                                            class="btn btn-sm btn-outline-secondary"
                                        >
                                            عرض
                                        </a>

                                        <a
                                            href="?route=cases/edit&id=<?= (int) $case['id'] ?>"
                                            class="btn btn-sm btn-primary"
                                        >
                                            تعديل
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>


        <!-- Pagination -->

        <div
            class="card-footer d-flex align-items-center justify-content-center"
            id="cases-pagination"
        >

            <?php if ($totalPages > 1): ?>

                <ul class="pagination m-0">

                    <!-- Previous -->

                    <?php if ($page > 1): ?>

                        <?php
                        $paginationParams['page'] = $page - 1;
                        ?>

                        <li class="page-item">

                            <a
                                class="page-link"
                                href="?<?= htmlspecialchars(
                                    http_build_query($paginationParams),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                            >
                                السابق
                            </a>

                        </li>

                    <?php else: ?>

                        <li class="page-item disabled">

                            <span class="page-link">
                                السابق
                            </span>

                        </li>

                    <?php endif; ?>


                    <!-- Pages -->

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                        <?php
                        $paginationParams['page'] = $i;
                        ?>

                        <li
                            class="page-item <?= $i === $page ? 'active' : '' ?>"
                        >

                            <?php if ($i === $page): ?>

                                <span class="page-link">
                                    <?= $i ?>
                                </span>

                            <?php else: ?>

                                <a
                                    class="page-link"
                                    href="?<?= htmlspecialchars(
                                        http_build_query($paginationParams),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                >
                                    <?= $i ?>
                                </a>

                            <?php endif; ?>

                        </li>

                    <?php endfor; ?>


                    <!-- Next -->

                    <?php if ($page < $totalPages): ?>

                        <?php
                        $paginationParams['page'] = $page + 1;
                        ?>

                        <li class="page-item">

                            <a
                                class="page-link"
                                href="?<?= htmlspecialchars(
                                    http_build_query($paginationParams),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                            >
                                التالي
                            </a>

                        </li>

                    <?php else: ?>

                        <li class="page-item disabled">

                            <span class="page-link">
                                التالي
                            </span>

                        </li>

                    <?php endif; ?>

                </ul>

            <?php endif; ?>

        </div>

    </div>

</div>


<script>

    const searchInput = document.getElementById('search');
    const statusSelect = document.getElementById('status');
    const caseTypeSelect = document.getElementById('case_type_id');
    const lawyerSelect = document.getElementById('lawyer_id');

    const tableBody = document.getElementById('cases-table-body');
    const paginationContainer = document.getElementById('cases-pagination');
    const casesCount = document.getElementById('cases-count');


    /*
     * ------------------------------------------------------------
     * Status Labels
     * ------------------------------------------------------------
     */

    const statusLabels = {
        pending: 'قيد الانتظار',
        active: 'نشطة',
        on_hold: 'معلقة',
        closed: 'مغلقة',
        cancelled: 'ملغاة'
    };


    /*
     * ------------------------------------------------------------
     * Status Classes
     * ------------------------------------------------------------
     */

    const statusClasses = {
        pending: 'bg-yellow-lt text-yellow',
        active: 'bg-green-lt text-green',
        on_hold: 'bg-orange-lt text-orange',
        closed: 'bg-blue-lt text-blue',
        cancelled: 'bg-red-lt text-red'
    };


    /*
     * ------------------------------------------------------------
     * Build Request Parameters
     * ------------------------------------------------------------
     */

    function buildParams(page = 1) {

        const params = new URLSearchParams();

        params.set(
            'search',
            searchInput.value.trim()
        );

        params.set(
            'status',
            statusSelect.value
        );

        params.set(
            'case_type_id',
            caseTypeSelect.value
        );

        if (lawyerSelect) {

            params.set(
                'lawyer_id',
                lawyerSelect.value
            );

        }

        params.set(
            'page',
            page
        );

        return params;
    }


    /*
     * ------------------------------------------------------------
     * Create Empty State
     * ------------------------------------------------------------
     */

    function renderEmptyState() {

        tableBody.innerHTML = '';

        const row = document.createElement('tr');

        const cell = document.createElement('td');

        cell.colSpan = 10;

        cell.className = 'text-center py-5';

        const wrapper = document.createElement('div');

        wrapper.className = 'empty';

        const title = document.createElement('p');

        title.className = 'empty-title';

        title.textContent = 'لا توجد قضايا';

        const subtitle = document.createElement('p');

        subtitle.className = 'empty-subtitle text-secondary';

        subtitle.textContent =
            'لا توجد قضايا مطابقة لمعايير البحث الحالية.';

        wrapper.appendChild(title);
        wrapper.appendChild(subtitle);

        cell.appendChild(wrapper);
        row.appendChild(cell);

        tableBody.appendChild(row);
    }


    /*
     * ------------------------------------------------------------
     * Create Status Badge
     * ------------------------------------------------------------
     */

    function createStatusBadge(status) {

        const badge = document.createElement('span');

        badge.className =
            'badge ' +
            (statusClasses[status] ?? 'bg-secondary-lt text-secondary');

        badge.textContent =
            statusLabels[status] ?? status;

        return badge;
    }


    /*
     * ------------------------------------------------------------
     * Render Cases
     * ------------------------------------------------------------
     */

    function renderCases(cases) {

        tableBody.innerHTML = '';

        if (!cases.length) {

            renderEmptyState();

            return;
        }


        cases.forEach(caseItem => {

            const row = document.createElement('tr');


            /*
             * ID
             */

            const idCell = document.createElement('td');

            idCell.className = 'text-secondary';

            idCell.textContent = caseItem.id;

            row.appendChild(idCell);


            /*
             * Case Number
             */

            const caseNumberCell =
                document.createElement('td');

            const caseNumberText =
                document.createElement('span');

            caseNumberText.className = 'fw-semibold';

            caseNumberText.textContent =
                caseItem.case_number;

            caseNumberCell.appendChild(caseNumberText);

            row.appendChild(caseNumberCell);


            /*
             * Title
             */

            const titleCell =
                document.createElement('td');

            titleCell.textContent =
                caseItem.title;

            row.appendChild(titleCell);


            /*
             * Client
             */

            const clientCell =
                document.createElement('td');

            clientCell.textContent =
                caseItem.client_name;

            row.appendChild(clientCell);


            /*
             * Lawyer
             */

            const lawyerCell =
                document.createElement('td');

            lawyerCell.textContent =
                caseItem.lawyer_name;

            row.appendChild(lawyerCell);


            /*
             * Case Type
             */

            const caseTypeCell =
                document.createElement('td');

            caseTypeCell.textContent =
                caseItem.case_type_name;

            row.appendChild(caseTypeCell);


            /*
             * Court
             */

            const courtCell =
                document.createElement('td');

            const courtName =
                document.createElement('div');

            courtName.textContent =
                caseItem.court_name || '';

            courtCell.appendChild(courtName);

            if (caseItem.court_number) {

                const courtNumber =
                    document.createElement('div');

                courtNumber.className =
                    'text-secondary small';

                courtNumber.textContent =
                    'رقم: ' + caseItem.court_number;

                courtCell.appendChild(courtNumber);

            }

            row.appendChild(courtCell);


            /*
             * Status
             */

            const statusCell =
                document.createElement('td');

            statusCell.appendChild(
                createStatusBadge(caseItem.status)
            );

            row.appendChild(statusCell);


            /*
             * Filing Date
             */

            const filingDateCell =
                document.createElement('td');

            filingDateCell.textContent =
                caseItem.filing_date || '';

            row.appendChild(filingDateCell);


            /*
             * Actions
             */

            const actionsCell =
                document.createElement('td');

            const actions =
                document.createElement('div');

            actions.className =
                'btn-list justify-content-end';


            /*
             * Show
             */

            const showLink =
                document.createElement('a');

            showLink.href =
                '?route=cases/show&id=' +
                encodeURIComponent(caseItem.id);

            showLink.className =
                'btn btn-sm btn-outline-secondary';

            showLink.textContent =
                'عرض';


            /*
             * Edit
             */

            const editLink =
                document.createElement('a');

            editLink.href =
                '?route=cases/edit&id=' +
                encodeURIComponent(caseItem.id);

            editLink.className =
                'btn btn-sm btn-primary';

            editLink.textContent =
                'تعديل';


            actions.appendChild(showLink);
            actions.appendChild(editLink);

            actionsCell.appendChild(actions);

            row.appendChild(actionsCell);


            tableBody.appendChild(row);

        });

    }


    /*
     * ------------------------------------------------------------
     * Render Pagination
     * ------------------------------------------------------------
     */

    function renderPagination(
        currentPage,
        totalPages
    ) {

        paginationContainer.innerHTML = '';

        if (totalPages <= 1) {

            return;
        }


        const pagination =
            document.createElement('ul');

        pagination.className =
            'pagination m-0';


        /*
         * Previous
         */

        const previousItem =
            document.createElement('li');

        previousItem.className =
            'page-item';

        if (currentPage <= 1) {

            previousItem.classList.add('disabled');

        }

        const previousLink =
            document.createElement(
                currentPage > 1
                    ? 'a'
                    : 'span'
            );

        previousLink.className =
            'page-link';

        previousLink.textContent =
            'السابق';

        if (currentPage > 1) {

            previousLink.href = '#';

            previousLink.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    loadCases(currentPage - 1);

                }
            );

        }

        previousItem.appendChild(previousLink);

        pagination.appendChild(previousItem);


        /*
         * Pages
         */

        for (
            let i = 1;
            i <= totalPages;
            i++
        ) {

            const pageItem =
                document.createElement('li');

            pageItem.className =
                'page-item';

            if (i === currentPage) {

                pageItem.classList.add('active');

                const pageSpan =
                    document.createElement('span');

                pageSpan.className =
                    'page-link';

                pageSpan.textContent =
                    i;

                pageItem.appendChild(pageSpan);

            } else {

                const pageLink =
                    document.createElement('a');

                pageLink.href = '#';

                pageLink.className =
                    'page-link';

                pageLink.textContent =
                    i;

                pageLink.addEventListener(
                    'click',
                    function (event) {

                        event.preventDefault();

                        loadCases(i);

                    }
                );

                pageItem.appendChild(pageLink);

            }

            pagination.appendChild(pageItem);

        }


        /*
         * Next
         */

        const nextItem =
            document.createElement('li');

        nextItem.className =
            'page-item';

        if (currentPage >= totalPages) {

            nextItem.classList.add('disabled');

        }

        const nextLink =
            document.createElement(
                currentPage < totalPages
                    ? 'a'
                    : 'span'
            );

        nextLink.className =
            'page-link';

        nextLink.textContent =
            'التالي';

        if (currentPage < totalPages) {

            nextLink.href = '#';

            nextLink.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    loadCases(currentPage + 1);

                }
            );

        }

        nextItem.appendChild(nextLink);

        pagination.appendChild(nextItem);

        paginationContainer.appendChild(
            pagination
        );
    }


    /*
     * ------------------------------------------------------------
     * Loading State
     * ------------------------------------------------------------
     */

    function renderLoading() {

        tableBody.innerHTML = '';

        const row =
            document.createElement('tr');

        const cell =
            document.createElement('td');

        cell.colSpan = 10;

        cell.className =
            'text-center py-5';

        const spinner =
            document.createElement('div');

        spinner.className =
            'spinner-border';

        spinner.setAttribute(
            'role',
            'status'
        );

        const visuallyHidden =
            document.createElement('span');

        visuallyHidden.className =
            'visually-hidden';

        visuallyHidden.textContent =
            'جاري تحميل القضايا...';

        spinner.appendChild(
            visuallyHidden
        );

        cell.appendChild(spinner);

        row.appendChild(cell);

        tableBody.appendChild(row);
    }


    /*
     * ------------------------------------------------------------
     * Load Cases
     * ------------------------------------------------------------
     */

    async function loadCases(page = 1) {

        renderLoading();

        const params =
            buildParams(page);

        try {

            const response =
                await fetch(
                    '?route=cases/search&' +
                    params.toString(),
                    {
                        headers: {
                            'X-Requested-With':
                                'XMLHttpRequest'
                        }
                    }
                );

            if (!response.ok) {

                throw new Error(
                    'Failed to load cases.'
                );

            }

            const data =
                await response.json();

            if (!data.success) {

                throw new Error(
                    'Failed to load cases.'
                );

            }

            renderCases(
                data.cases
            );

            renderPagination(
                data.page,
                data.totalPages
            );

            casesCount.textContent =
                `${data.total} قضية`;

        } catch (error) {

            tableBody.innerHTML = '';

            const row =
                document.createElement('tr');

            const cell =
                document.createElement('td');

            cell.colSpan = 10;

            cell.className =
                'text-center py-5 text-danger';

            cell.textContent =
                'حدث خطأ أثناء تحميل القضايا. حاول مرة أخرى.';

            row.appendChild(cell);

            tableBody.appendChild(row);

        }

    }


    /*
     * ------------------------------------------------------------
     * Search Debounce
     * ------------------------------------------------------------
     */

    let searchTimeout = null;

    searchInput.addEventListener(
        'input',
        function () {

            clearTimeout(searchTimeout);

            searchTimeout =
                setTimeout(
                    function () {

                        loadCases(1);

                    },
                    350
                );

        }
    );


    /*
     * ------------------------------------------------------------
     * Filters
     * ------------------------------------------------------------
     */

    statusSelect.addEventListener(
        'change',
        function () {

            loadCases(1);

        }
    );


    caseTypeSelect.addEventListener(
        'change',
        function () {

            loadCases(1);

        }
    );


    if (lawyerSelect) {

        lawyerSelect.addEventListener(
            'change',
            function () {

                loadCases(1);

            }
        );

    }

</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>