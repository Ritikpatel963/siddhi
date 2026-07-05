<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? 'Dashboard';
$active = $active ?? '';
$siteName = 'myExam Pre';
try {
    $siteName = setting($pdo, 'site_name', 'myExam Pre');
} catch (Throwable $e) {
    $siteName = 'myExam Pre';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | <?= e($siteName) ?></title>
    <link rel="icon" href="<?= e(url('assets/images/favicon.svg')) ?>" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= e(url('assets/css/style.css')) ?>" rel="stylesheet">
</head>
<body>
<div class="app-shell">
<?php include __DIR__ . '/sidebar.php'; ?>
<main class="main-content">
    <nav class="topbar">
        <button class="btn btn-outline-secondary d-lg-none" id="sidebarToggle" type="button" aria-label="Toggle menu">
            <i class="bi bi-list"></i>
        </button>
        <div>
            <h1><?= e($pageTitle) ?></h1>
        </div>
        <div class="dropdown ms-auto">
            <button class="btn profile-menu dropdown-toggle" data-bs-toggle="dropdown" type="button">
                <span class="avatar"><?= e(strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1))) ?></span>
                <?= e($_SESSION['admin_name'] ?? 'Admin') ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= e(url('modules/profile/index.php')) ?>">Profile</a></li>
                <li><a class="dropdown-item" href="<?= e(url('modules/settings/index.php')) ?>">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= e(url('auth/logout.php')) ?>">Logout</a></li>
            </ul>
        </div>
    </nav>
    <section class="content-area">
        <?php if ($success = flash('success')): ?>
            <div class="alert alert-success"><?= e($success) ?></div>
        <?php endif; ?>
        <?php if ($error = flash('error')): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>
