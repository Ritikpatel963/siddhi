<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

$pageTitle = 'Dashboard';
$active = 'dashboard';

$stats = [
    'Total Courses' => $pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn(),
    'Total Subjects' => $pdo->query('SELECT COUNT(*) FROM subjects')->fetchColumn(),
    'Learning Resources' => $pdo->query('SELECT COUNT(*) FROM resources')->fetchColumn(),
    'Published Quizzes' => $pdo->query("SELECT COUNT(*) FROM quizzes WHERE status = 'published'")->fetchColumn(),
    'Total Students' => $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn(),
    'Attempts This Month' => $pdo->query("SELECT COUNT(*) FROM quiz_attempts WHERE attempted_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')")->fetchColumn(),
];

$chartStmt = $pdo->query("
    SELECT DATE_FORMAT(months.month_start, '%b %Y') label, COUNT(quiz_attempts.id) attempts
    FROM (
        SELECT DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 5 MONTH) month_start
        UNION SELECT DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 4 MONTH)
        UNION SELECT DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 3 MONTH)
        UNION SELECT DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 2 MONTH)
        UNION SELECT DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH)
        UNION SELECT DATE_FORMAT(CURDATE(), '%Y-%m-01')
    ) months
    LEFT JOIN quiz_attempts ON DATE_FORMAT(quiz_attempts.attempted_at, '%Y-%m-01') = months.month_start
    GROUP BY months.month_start
    ORDER BY months.month_start
");
$chartRows = $chartStmt->fetchAll();

$recent = $pdo->query("
    SELECT qa.*, s.name student_name, q.title quiz_title
    FROM quiz_attempts qa
    JOIN students s ON s.id = qa.student_id
    JOIN quizzes q ON q.id = qa.quiz_id
    ORDER BY qa.attempted_at DESC
    LIMIT 10
")->fetchAll();

$recentStudents = $pdo->query("SELECT s.id, s.name, s.email, s.status, s.created_at, GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR ' · ') course_names FROM students s LEFT JOIN student_courses sc ON sc.student_id = s.id LEFT JOIN courses c ON c.id = sc.course_id GROUP BY s.id ORDER BY s.created_at DESC LIMIT 8")->fetchAll();

include __DIR__ . '/../includes/header.php';
?>
<!-- Welcome Bar -->
<div class="wbar">
    <div><h2>Welcome back, <?= e($_SESSION['admin_name'] ?? 'Admin') ?>! 👋</h2><p>Here's what's happening today.</p></div>
</div>

<!-- Stat Cards -->
<div class="sc-row">
    <?php 
    $icons = [
        'Total Courses' => ['c' => 't', 'svg' => '<path d="M22 10V6a2 2 0 00-2-2H4a2 2 0 00-2 2v4"/><path d="M2 10h20v10a2 2 0 01-2 2H4a2 2 0 01-2-2V10z"/>'],
        'Total Subjects' => ['c' => 'p', 'svg' => '<path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>'],
        'Learning Resources' => ['c' => 'g', 'svg' => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>'],
        'Published Quizzes' => ['c' => 'r', 'svg' => '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>'],
        'Total Students' => ['c' => 't', 'svg' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>'],
        'Attempts This Month' => ['c' => 'p', 'svg' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>'],
    ];
    foreach ($stats as $label => $value): 
        $icon = $icons[$label] ?? ['c' => 't', 'svg' => '<circle cx="12" cy="12" r="10"/>'];
    ?>
    <div class="sc">
        <div><div class="sc-lbl"><?= e($label) ?></div><div class="sc-val"><?= e($value) ?></div></div>
        <div class="sc-ico <?= $icon['c'] ?>"><svg viewBox="0 0 24 24" style="stroke:currentColor; fill:none; stroke-width:2; width:22px; height:22px;"><?= $icon['svg'] ?></svg></div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Quick Access -->
<div class="fw">
    <div class="card">
        <div class="sh"><h3>Quick Actions</h3></div>
        <div class="qa-grid" style="grid-template-columns:repeat(auto-fit, minmax(140px, 1fr));">
            <a class="qa-btn" href="<?= e(url('modules/courses/add.php')) ?>"><div class="qa-ic" style="background:var(--teal-light)"><svg viewBox="0 0 24 24" style="stroke:var(--teal)"><path d="M22 10V6a2 2 0 00-2-2H4a2 2 0 00-2 2v4"/></svg></div><span>Add Course</span></a>
            <a class="qa-btn" href="<?= e(url('modules/subjects/index.php')) ?>"><div class="qa-ic" style="background:var(--purple-light)"><svg viewBox="0 0 24 24" style="stroke:var(--purple)"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/></svg></div><span>Add Subject</span></a>
            <a class="qa-btn" href="<?= e(url('modules/resources/index.php')) ?>"><div class="qa-ic" style="background:var(--gold-light)"><svg viewBox="0 0 24 24" style="stroke:var(--gold)"><path d="M14 2H6a2 2 0 00-2 2v16"/></svg></div><span>Upload Resource</span></a>
            <a class="qa-btn" href="<?= e(url('modules/quizzes/index.php')) ?>"><div class="qa-ic" style="background:var(--red-light)"><svg viewBox="0 0 24 24" style="stroke:var(--red)"><path d="M9 11l3 3L22 4"/></svg></div><span>Create Quiz</span></a>
            <a class="qa-btn" href="<?= e(url('modules/study-plans/index.php')) ?>"><div class="qa-ic" style="background:var(--blue-light)"><svg viewBox="0 0 24 24" style="stroke:var(--blue)"><rect x="3" y="4" width="18" height="18" rx="2"/></svg></div><span>Study Plan</span></a>
            <a class="qa-btn" href="<?= e(url('modules/students/add.php')) ?>"><div class="qa-ic" style="background:var(--green-light)"><svg viewBox="0 0 24 24" style="stroke:var(--green)"><path d="M17 21v-2a4 4 0 00-4-4H5"/><circle cx="9" cy="7" r="4"/></svg></div><span>Add Student</span></a>
        </div>
    </div>
</div>

<!-- Chart and Quiz Results -->
<div class="g2">
    <div class="card">
        <div class="sh"><h3>Quiz Attempts (Last 6 Months)</h3></div>
        <div class="bar-chart-wrap" style="position:relative; width:100%; height:280px;"><canvas id="attemptChart"></canvas></div>
    </div>
    <div class="card">
        <div class="sh"><h3>Recent Quiz Results</h3></div>
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead><tr><th>Student</th><th>Quiz</th><th>Score</th><th>Status</th><th>Attempted</th></tr></thead>
                <tbody>
                <?php foreach ($recent as $row): ?>
                    <tr>
                        <td><?= e($row['student_name']) ?></td>
                        <td><?= e($row['quiz_title']) ?></td>
                        <td><?= e($row['score']) ?>/<?= e($row['total_marks']) ?></td>
                        <td><?= status_badge($row['status']) ?></td>
                        <td><?= e(format_date($row['attempted_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Students -->
<div class="fw">
    <div class="card">
        <div class="sh"><h3>Recent Students</h3><a href="<?= e(url('modules/students/list.php')) ?>">View all students</a></div>
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead><tr><th>Student</th><th>Assigned Courses</th><th>Status</th><th>Joined</th></tr></thead>
                <tbody>
                <?php foreach ($recentStudents as $student): ?>
                    <tr>
                        <td><strong><?= e($student['name']) ?></strong><div class="small text-secondary"><?= e($student['email']) ?></div></td>
                        <td><?= e($student['course_names'] ?: 'Not enrolled') ?></td>
                        <td><?= status_badge($student['status']) ?></td>
                        <td><?= e(format_date($student['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function () {
    const ctx = document.getElementById('attemptChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($chartRows, 'label')) ?>,
                datasets: [{ label: 'Attempts', data: <?= json_encode(array_map('intval', array_column($chartRows, 'attempts'))) ?>, backgroundColor: '#0d7a6e', borderRadius: 4 }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });
    }
});
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
