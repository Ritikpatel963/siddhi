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
<div class="row g-3 mb-4">
    <?php foreach ($stats as $label => $value): ?>
        <div class="col-md-6 col-xl-4">
            <div class="stat-card">
                <div class="value"><?= e($value) ?></div>
                <div class="label"><?= e($label) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row g-3">
    <div class="col-xl-8">
        <div class="panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Quiz Attempts</h2>
                <span class="text-secondary">Last 6 months</span>
            </div>
            <canvas id="attemptChart" height="110"></canvas>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="panel">
            <h2 class="h5 mb-3">Quick Actions</h2>
            <div class="d-grid gap-2">
                <a class="btn btn-primary" href="<?= e(url('modules/courses/add.php')) ?>">Add Course</a>
                <a class="btn btn-outline-primary" href="<?= e(url('modules/subjects/index.php')) ?>">Add Subject</a>
                <a class="btn btn-outline-primary" href="<?= e(url('modules/resources/index.php')) ?>">Upload Resource</a>
                <a class="btn btn-outline-primary" href="<?= e(url('modules/quizzes/index.php')) ?>">Create Quiz</a>
                <a class="btn btn-outline-primary" href="<?= e(url('modules/study-plans/index.php')) ?>">Build Study Plan</a>
                <a class="btn btn-outline-primary" href="<?= e(url('modules/students/add.php')) ?>">Add Student</a>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="panel">
            <h2 class="h5 mb-3">Recent Quiz Results</h2>
            <div class="table-responsive">
                <table class="table align-middle">
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
                    <?php if (!$recent): ?><tr><td colspan="5" class="text-center text-secondary">No results yet.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="panel">
            <div class="d-flex justify-content-between align-items-center mb-3"><h2 class="h5 mb-0">Recent Students</h2><a class="btn btn-sm btn-outline-primary" href="<?= e(url('modules/students/list.php')) ?>">View all students</a></div>
            <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Student</th><th>Assigned Courses</th><th>Status</th><th>Joined</th></tr></thead><tbody><?php foreach ($recentStudents as $student): ?><tr><td><strong><?= e($student['name']) ?></strong><div class="small text-secondary"><?= e($student['email']) ?></div></td><td><?= e($student['course_names'] ?: 'Not enrolled') ?></td><td><?= status_badge($student['status']) ?></td><td><?= e(format_date($student['created_at'])) ?></td></tr><?php endforeach; ?><?php if (!$recentStudents): ?><tr><td colspan="4" class="text-center text-secondary">No students yet.</td></tr><?php endif; ?></tbody></table></div>
        </div>
    </div>
</div>
<script>
window.addEventListener('load', function () {
    const ctx = document.getElementById('attemptChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($chartRows, 'label')) ?>,
            datasets: [{ label: 'Attempts', data: <?= json_encode(array_map('intval', array_column($chartRows, 'attempts'))) ?>, backgroundColor: '#2f80ed' }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
    });
});
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
