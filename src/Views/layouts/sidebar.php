<?php

use LawFirmManagement\Core\Session;

$currentRoute = $_GET['route'] ?? '';
$userRole = Session::get('user_role');

$isDashboard = $currentRoute === 'dashboard';
$isUsers = str_starts_with($currentRoute, 'users');
$isClients = str_starts_with($currentRoute, 'clients');
$isCases = str_starts_with($currentRoute, 'cases');
$isAppointments = str_starts_with($currentRoute, 'appointments');

?>

<aside class="navbar navbar-vertical navbar-expand-lg">

    <div class="container-fluid">

        <!-- Mobile Toggle -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu"
            aria-expanded="false"
            aria-label="فتح القائمة"
        >
            <span class="navbar-toggler-icon"></span>
        </button>


        <!-- Logo -->
        <h1 class="navbar-brand navbar-brand-autodark">

            <a href="?route=dashboard">

                <span class="law-brand-icon">
                    ⚖️
                </span>

                <span>
                    مكتب المحاماة
                </span>

            </a>

        </h1>


        <!-- Navigation -->
        <div
            class="collapse navbar-collapse"
            id="sidebar-menu"
        >

            <ul class="navbar-nav pt-lg-3">


                <!-- Dashboard -->
                <li class="nav-item <?= $isDashboard ? 'active' : '' ?>">

                    <a
                        class="nav-link"
                        href="?route=dashboard"
                        <?= $isDashboard ? 'aria-current="page"' : '' ?>
                    >

                        <span class="nav-link-icon d-md-none d-lg-inline-block">

                            <i class="ti ti-dashboard"></i>

                        </span>

                        <span class="nav-link-title">
                            لوحة التحكم
                        </span>

                    </a>

                </li>


                <!-- Users - Admin Only -->
                <?php if ($userRole === 'admin'): ?>

                    <li class="nav-item <?= $isUsers ? 'active' : '' ?>">

                        <a
                            class="nav-link"
                            href="?route=users"
                            <?= $isUsers ? 'aria-current="page"' : '' ?>
                        >

                            <span class="nav-link-icon d-md-none d-lg-inline-block">

                                <i class="ti ti-users"></i>

                            </span>

                            <span class="nav-link-title">
                                المستخدمون
                            </span>

                        </a>

                    </li>

                <?php endif; ?>


                <!-- Clients - Admin & Staff -->
                <?php if (in_array($userRole, ['admin', 'staff'], true)): ?>

                    <li class="nav-item <?= $isClients ? 'active' : '' ?>">

                        <a
                            class="nav-link"
                            href="?route=clients"
                            <?= $isClients ? 'aria-current="page"' : '' ?>
                        >

                            <span class="nav-link-icon d-md-none d-lg-inline-block">

                                <i class="ti ti-users-group"></i>

                            </span>

                            <span class="nav-link-title">
                                العملاء
                            </span>

                        </a>

                    </li>

                <?php endif; ?>


                <!-- Cases -->
                <li class="nav-item <?= $isCases ? 'active' : '' ?>">

                    <a
                        class="nav-link"
                        href="?route=cases"
                        <?= $isCases ? 'aria-current="page"' : '' ?>
                    >

                        <span class="nav-link-icon d-md-none d-lg-inline-block">

                            <i class="ti ti-briefcase"></i>

                        </span>

                        <span class="nav-link-title">
                            القضايا
                        </span>

                    </a>

                </li>


                <!-- Appointments -->
                <li class="nav-item <?= $isAppointments ? 'active' : '' ?>">

                    <a
                        class="nav-link"
                        href="?route=appointments"
                        <?= $isAppointments ? 'aria-current="page"' : '' ?>
                    >

                        <span class="nav-link-icon d-md-none d-lg-inline-block">

                            <i class="ti ti-calendar-event"></i>

                        </span>

                        <span class="nav-link-title">
                            المواعيد
                        </span>

                    </a>

                </li>


            </ul>

        </div>

    </div>

</aside>