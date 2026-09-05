<?php

$old = \LawFirmManagement\Core\Flash::get('old') ?? [];

$search = $search ?? '';
$status = $status ?? null;
$caseTypeId = $caseTypeId ?? null;
$lawyerId = $lawyerId ?? null;
$page = $page ?? 1;
$totalPages = $totalPages ?? 1;

?>

<div class="page-header">
    <div>
        <h1>القضايا</h1>
        <p>إدارة ومتابعة قضايا المكتب.</p>
    </div>

    <?php if ($currentUser === 'admin'): ?>
        <a href="?route=cases/create" class="btn">
            إضافة قضية
        </a>
    <?php endif; ?>
</div>

<!-- Search & Filters -->
<div class="filters">

    <div class="filter-group">
        <label for="search">بحث</label>
        <input
            type="text"
            id="search"
            name="search"
            value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
            placeholder="رقم القضية أو عنوانها..."
        >
    </div>

    <div class="filter-group">
        <label for="status">الحالة</label>

        <select id="status" name="status">

            <option value="">كل الحالات</option>

            <option
                value="pending"
                <?= $status === 'pending' ? 'selected' : '' ?>
            >
                قيد الانتظار
            </option>

            <option
                value="active"
                <?= $status === 'active' ? 'selected' : '' ?>
            >
                نشطة
            </option>

            <option
                value="on_hold"
                <?= $status === 'on_hold' ? 'selected' : '' ?>
            >
                معلقة
            </option>

            <option
                value="closed"
                <?= $status === 'closed' ? 'selected' : '' ?>
            >
                مغلقة
            </option>

            <option
                value="cancelled"
                <?= $status === 'cancelled' ? 'selected' : '' ?>
            >
                ملغاة
            </option>

        </select>
    </div>

    <div class="filter-group">
        <label for="case_type_id">نوع القضية</label>

        <select id="case_type_id" name="case_type_id">

            <option value="">كل الأنواع</option>

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


    <?php if ($currentUser['role'] !== 'lawyer'): ?>

        <div class="filter-group">

            <label for="lawyer_id">المحامي</label>

            <select id="lawyer_id" name="lawyer_id">

                <option value="">كل المحامين</option>

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


<!-- Cases Table -->
<div class="table-container">

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


        <!--
            مهم:
            الـ tbody موجود دائمًا حتى لو لم توجد نتائج.
            الـ JavaScript يعتمد عليه في AJAX.
        -->
        <tbody id="cases-table-body">

            <?php if (empty($cases)): ?>

                <tr>

                    <td colspan="10" class="empty">

                        لا توجد قضايا مطابقة للبحث.

                    </td>

                </tr>

            <?php else: ?>

                <?php foreach ($cases as $case): ?>

                    <tr>

                        <td>
                            <?= (int) $case['id'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $case['case_number'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $case['title'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $case['client_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $case['lawyer_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $case['case_type_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>

                            <?= htmlspecialchars(
                                $case['court_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                            <?php if (!empty($case['court_number'])): ?>

                                -
                                <?= htmlspecialchars(
                                    $case['court_number'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            <?php endif; ?>

                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $case['status'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $case['filing_date'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
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

            <?php endif; ?>

        </tbody>

    </table>

</div>


<!-- Pagination -->

<!--
    مهم:
    الـ div موجود دائمًا.
    الـ JavaScript سيقوم بإخفائه/تعبئته حسب عدد الصفحات.
-->
<div
    class="pagination"
    id="cases-pagination"
>

    <?php if ($totalPages > 1): ?>

        <?php

        $paginationParams = [
            'route' => 'cases',
            'search' => $search,
            'status' => $status,
            'case_type_id' => $caseTypeId,
            'lawyer_id' => $lawyerId,
        ];

        ?>


        <!-- Previous -->

        <?php if ($page > 1): ?>

            <?php
            $paginationParams['page'] = $page - 1;
            ?>

            <a
                href="?<?= htmlspecialchars(
                    http_build_query($paginationParams),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >
                السابق
            </a>

        <?php else: ?>

            <span class="disabled">
                السابق
            </span>

        <?php endif; ?>


        <!-- Pages -->

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
                    href="?<?= htmlspecialchars(
                        http_build_query($paginationParams),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >
                    <?= $i ?>
                </a>

            <?php endif; ?>

        <?php endfor; ?>


        <!-- Next -->

        <?php if ($page < $totalPages): ?>

            <?php
            $paginationParams['page'] = $page + 1;
            ?>

            <a
                href="?<?= htmlspecialchars(
                    http_build_query($paginationParams),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >
                التالي
            </a>

        <?php else: ?>

            <span class="disabled">
                التالي
            </span>

        <?php endif; ?>

    <?php endif; ?>

</div>


<script>

    /*
     * ============================================================
     * AJAX CASE SEARCH / FILTER / PAGINATION
     * ============================================================
     */


    const searchInput = document.getElementById('search');

    const statusSelect = document.getElementById('status');

    const caseTypeSelect = document.getElementById('case_type_id');

    const lawyerSelect = document.getElementById('lawyer_id');

    const tableBody = document.getElementById('cases-table-body');

    const paginationContainer =
        document.getElementById('cases-pagination');


    /*
     * ------------------------------------------------------------
     * Build URL Parameters
     * ------------------------------------------------------------
     */

    function buildParams(page = 1) {

        const params = new URLSearchParams();

        params.set('search', searchInput.value.trim());

        params.set('status', statusSelect.value);

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

        params.set('page', page);

        return params;
    }


    /*
     * ------------------------------------------------------------
     * Render Cases
     * ------------------------------------------------------------
     */

    function renderCases(cases) {

        tableBody.innerHTML = '';

        if (!cases.length) {

            const row = document.createElement('tr');

            const cell = document.createElement('td');

            cell.colSpan = 10;

            cell.className = 'empty';

            cell.textContent =
                'لا توجد قضايا مطابقة للبحث.';

            row.appendChild(cell);

            tableBody.appendChild(row);

            return;
        }


        cases.forEach(caseItem => {

            const row = document.createElement('tr');


            /*
             * ID
             */

            const idCell =
                document.createElement('td');

            idCell.textContent =
                caseItem.id;

            row.appendChild(idCell);


            /*
             * Case Number
             */

            const caseNumberCell =
                document.createElement('td');

            caseNumberCell.textContent =
                caseItem.case_number;

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

            courtCell.textContent =
                caseItem.court_name || '';

            if (caseItem.court_number) {

                courtCell.textContent +=
                    ' - ' + caseItem.court_number;

            }

            row.appendChild(courtCell);


            /*
             * Status
             */

            const statusCell =
                document.createElement('td');

            statusCell.textContent =
                caseItem.status;

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


            const editLink =
                document.createElement('a');

            editLink.href =
                '?route=cases/edit&id=' +
                encodeURIComponent(caseItem.id);

            editLink.className =
                'edit-btn';

            editLink.textContent =
                'تعديل';


            const showLink =
                document.createElement('a');

            showLink.href =
                '?route=cases/show&id=' +
                encodeURIComponent(caseItem.id);

            showLink.className =
                'edit-btn';

            showLink.textContent =
                'عرض';


            actionsCell.appendChild(editLink);

            actionsCell.appendChild(showLink);

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


        /*
         * Previous
         */

        if (currentPage > 1) {

            const previous =
                document.createElement('a');

            previous.href = '#';

            previous.textContent =
                'السابق';

            previous.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    loadCases(
                        currentPage - 1
                    );

                }
            );

            paginationContainer.appendChild(
                previous
            );

        } else {

            const previous =
                document.createElement('span');

            previous.className =
                'disabled';

            previous.textContent =
                'السابق';

            paginationContainer.appendChild(
                previous
            );

        }


        /*
         * Pages
         */

        for (
            let i = 1;
            i <= totalPages;
            i++
        ) {

            if (i === currentPage) {

                const active =
                    document.createElement('span');

                active.className =
                    'active';

                active.textContent =
                    i;

                paginationContainer.appendChild(
                    active
                );

            } else {

                const pageLink =
                    document.createElement('a');

                pageLink.href = '#';

                pageLink.textContent =
                    i;

                pageLink.addEventListener(
                    'click',
                    function (event) {

                        event.preventDefault();

                        loadCases(i);

                    }
                );

                paginationContainer.appendChild(
                    pageLink
                );

            }

        }


        /*
         * Next
         */

        if (currentPage < totalPages) {

            const next =
                document.createElement('a');

            next.href = '#';

            next.textContent =
                'التالي';

            next.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    loadCases(
                        currentPage + 1
                    );

                }
            );

            paginationContainer.appendChild(
                next
            );

        } else {

            const next =
                document.createElement('span');

            next.className =
                'disabled';

            next.textContent =
                'التالي';

            paginationContainer.appendChild(
                next
            );

        }

    }


    /*
     * ------------------------------------------------------------
     * Load Cases
     * ------------------------------------------------------------
     */

    async function loadCases(page = 1) {

        try {

            const params =
                buildParams(page);


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
                    'HTTP error: ' +
                    response.status
                );

            }


            const data =
                await response.json();


            if (!data.success) {

                throw new Error(
                    'Failed to load cases'
                );

            }


            renderCases(
                data.cases
            );


            renderPagination(
                data.page,
                data.totalPages
            );


        } catch (error) {

            console.error(error);

            tableBody.innerHTML = '';

            const row =
                document.createElement('tr');

            const cell =
                document.createElement('td');

            cell.colSpan = 10;

            cell.className = 'empty';

            cell.textContent =
                'حدث خطأ أثناء تحميل البيانات.';

            row.appendChild(cell);

            tableBody.appendChild(row);

            paginationContainer.innerHTML = '';

        }

    }


    /*
     * ------------------------------------------------------------
     * Search
     * ------------------------------------------------------------
     */

    let searchTimeout;

    searchInput.addEventListener(
        'input',
        function () {

            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(
                function () {

                    loadCases(1);

                },
                300
            );

        }
    );


    /*
     * ------------------------------------------------------------
     * Status Filter
     * ------------------------------------------------------------
     */

    statusSelect.addEventListener(
        'change',
        function () {

            loadCases(1);

        }
    );


    /*
     * ------------------------------------------------------------
     * Case Type Filter
     * ------------------------------------------------------------
     */

    caseTypeSelect.addEventListener(
        'change',
        function () {

            loadCases(1);

        }
    );


    /*
     * ------------------------------------------------------------
     * Lawyer Filter
     * ------------------------------------------------------------
     */

    if (lawyerSelect) {

        lawyerSelect.addEventListener(
            'change',
            function () {

                loadCases(1);

            }
        );

    }


</script>