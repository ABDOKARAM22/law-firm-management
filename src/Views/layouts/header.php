<?php

$pageTitle = $pageTitle ?? 'مكتب المحاماة';

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        <?= htmlspecialchars($pageTitle) ?> | مكتب المحاماة
    </title>

    <!-- Tabler RTL -->
    <link
        rel="stylesheet"
        href="assets/tabler/dist/css/tabler.rtl.min.css"
    >

    <!-- Application CSS -->
    <link
        rel="stylesheet"
        href="assets/css/app.css"
    >

</head>

<body>

<div class="page">

    <!-- Sidebar -->
    <?php require __DIR__ . '/sidebar.php'; ?>

    <div class="page-wrapper">

        <!-- Navbar -->
        <?php require __DIR__ . '/navbar.php'; ?>

        <!-- Page Content -->
        <div class="page-body">