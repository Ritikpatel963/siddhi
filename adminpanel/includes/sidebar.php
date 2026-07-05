<?php
$items = [
    'dashboard' => ['Dashboard', 'modules/dashboard.php', 'bi-speedometer2'],
    'courses' => ['Courses', 'modules/courses/list.php', 'bi-book'],
    'subjects' => ['Subjects', 'modules/subjects/index.php', 'bi-collection'],
    'resources' => ['Notes & Resources', 'modules/resources/index.php', 'bi-file-earmark-arrow-up'],
    'quizzes' => ['Quizzes', 'modules/quizzes/index.php', 'bi-ui-checks'],
    'study-plans' => ['Study Plans', 'modules/study-plans/index.php', 'bi-calendar-check'],
    'students' => ['Students', 'modules/students/list.php', 'bi-people'],
    'quiz-results' => ['Quiz Results', 'modules/quiz-results/index.php', 'bi-graph-up'],
    'profile' => ['Profile', 'modules/profile/index.php', 'bi-person'],
    'settings' => ['Settings', 'modules/settings/index.php', 'bi-gear'],
];
?>
<aside class="sidebar" id="sidebar">
    <a class="brand" href="<?= e(admin_url()) ?>">
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
