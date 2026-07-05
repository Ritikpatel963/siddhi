<?php
$items = [
    'dashboard' => ['Dashboard', 'modules/dashboard.php', 'bi-speedometer2'],
    'courses' => ['Courses', 'modules/courses/list.php', 'bi-book'],
    'exams' => ['Exams', 'modules/exams/list.php', 'bi-journal-text'],
    'questions' => ['Questions', 'modules/questions/list.php', 'bi-question-circle'],
    'students' => ['Students', 'modules/students/list.php', 'bi-people'],
    'results' => ['Results', 'modules/results/list.php', 'bi-graph-up'],
    'categories' => ['Categories', 'modules/categories/list.php', 'bi-tags'],
    'profile' => ['Profile', 'modules/profile/index.php', 'bi-person'],
    'settings' => ['Settings', 'modules/settings/index.php', 'bi-gear'],
];
?>
<aside class="sidebar" id="sidebar">
    <a class="brand" href="<?= e(url('modules/dashboard.php')) ?>">
        <span class="brand-mark">mE</span>
        <span>myExam Pre</span>
    </a>
    <nav class="nav flex-column">
        <?php foreach ($items as $key => [$label, $href, $icon]): ?>
            <a class="nav-link <?= $active === $key ? 'active' : '' ?>" href="<?= e(url($href)) ?>">
                <i class="bi <?= e($icon) ?>"></i>
                <span><?= e($label) ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
</aside>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
