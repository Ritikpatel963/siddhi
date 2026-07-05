<?php
require_once __DIR__ . '/../data.php';
$pageTitle = $pageTitle ?? 'Dashboard';
$active = $active ?? 'dashboard';
$nav = [
    'dashboard' => ['Dashboard', 'dashboard.php', 'bi-speedometer2'],
    'courses' => ['My Courses', 'courses.php', 'bi-book'],
    'resources' => ['Resources', 'resources.php', 'bi-file-earmark-arrow-down'],
    'quizzes' => ['Quizzes', 'quizzes.php', 'bi-ui-checks'],
    'results' => ['Quiz Results', 'results.php', 'bi-graph-up'],
    'profile' => ['Profile', 'profile.php', 'bi-person'],
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(student_url('assets/css/style.css')) ?>">
</head>
<body>
<div class="student-shell">
    <aside class="student-sidebar" id="studentSidebar">
        <a class="student-brand" href="<?= e(student_url('dashboard.php')) ?>"><span>mE</span><strong>myExam Pre</strong></a>
        <nav>
            <?php foreach ($nav as $key => [$label, $href, $icon]): ?>
                <a class="<?= $active === $key ? 'active' : '' ?>" href="<?= e(student_url($href)) ?>"><i class="bi <?= e($icon) ?>"></i><?= e($label) ?></a>
            <?php endforeach; ?>
        </nav>
    </aside>
    <main class="student-main">
        <header class="student-topbar">
            <button class="icon-btn" id="studentMenu" type="button"><i class="bi bi-list"></i></button>
            <div><h1><?= e($pageTitle) ?></h1><p><?= e($student['plan']) ?></p></div>
            <a class="student-profile" href="<?= e(student_url('profile.php')) ?>"><span><?= e($student['avatar']) ?></span><strong><?= e($student['name']) ?></strong></a>
        </header>
        <section class="student-content">
