<?php
$currentPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$items = [
    'dashboard' => ['Dashboard', 'modules/dashboard.php', 'bi-speedometer2'],
    'courses' => ['Courses', 'modules/courses/list.php', 'bi-book'],
    'subjects' => ['Subjects', 'modules/subjects/index.php', 'bi-collection'],
    'resources' => ['Notes & Resources', 'modules/resources/index.php', 'bi-file-earmark-arrow-up'],
    'quizzes' => ['Quizzes', 'modules/quizzes/index.php', 'bi-ui-checks', [
        ['Quiz Management', 'modules/quizzes/index.php', 'bi-list-check'],
        ['Create Quiz', 'modules/quizzes/form.php', 'bi-pencil-square'],
        ['Question Builder / Bank', 'modules/quizzes/questions.php', 'bi-question-circle'],
        ['Assign Students', 'modules/quizzes/assign.php', 'bi-person-check'],
        ['Quiz Preview', 'modules/quizzes/preview.php', 'bi-eye'],
        ['Results / Attempts', 'modules/quiz-results/index.php', 'bi-graph-up'],
            ]],
    'study-plans' => ['Study Plans', 'modules/study-plans/index.php', 'bi-calendar-check'],
    'students' => ['Students', 'modules/students/list.php', 'bi-people'],
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
        <?php foreach ($items as $key => $item): ?>
            <?php
            [$label, $href, $icon] = $item;
            $children = $item[3] ?? [];
            $isOpen = $active === $key || ($key === 'quizzes' && $active === 'quiz-results');
            ?>
            <?php if ($children): ?>
                <button class="nav-link nav-dropdown-toggle <?= $isOpen ? 'active' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#quizMenu" aria-expanded="<?= $isOpen ? 'true' : 'false' ?>" aria-controls="quizMenu">
                    <i class="bi <?= e($icon) ?>"></i>
                    <span><?= e($label) ?></span>
                    <i class="bi bi-chevron-down nav-caret"></i>
                </button>
                <div class="nav-sub collapse <?= $isOpen ? 'show' : '' ?>" id="quizMenu">
                    <?php foreach ($children as [$childLabel, $childHref, $childIcon]): ?>
                        <?php $isChildActive = strpos($currentPath, '/adminpanel/' . $childHref) !== false; ?>
                        <a class="nav-sub-link <?= $isChildActive ? 'active' : '' ?>" href="<?= e(url($childHref)) ?>">
                            <i class="bi <?= e($childIcon) ?>"></i>
                            <span><?= e($childLabel) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <a class="nav-link <?= $active === $key ? 'active' : '' ?>" href="<?= e(url($href)) ?>">
                    <i class="bi <?= e($icon) ?>"></i>
                    <span><?= e($label) ?></span>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
</aside>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
