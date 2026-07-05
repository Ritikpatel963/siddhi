<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

$pageTitle = 'Dashboard';
$active = 'dashboard';

$stats = [
    'Total Exams' => $pdo->query('SELECT COUNT(*) FROM exams')->fetchColumn(),
    'Total Courses' => $pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn(),
    'Total Students' => $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn(),
    'Total Questions' => $pdo->query('SELECT COUNT(*) FROM questions')->fetchColumn(),
    'Exams This Month' => $pdo->query("SELECT COUNT(DISTINCT exam_id) FROM results WHERE attempted_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')")->fetchColumn(),
];

$chartStmt = $pdo->query("
    SELECT DATE_FORMAT(months.month_start, '%b %Y') label, COUNT(results.id) attempts
    FROM (
        SELECT DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 5 MONTH) month_start
        UNION SELECT DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 4 MONTH)
        UNION SELECT DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 3 MONTH)
        UNION SELECT DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 2 MONTH)
        UNION SELECT DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH)
        UNION SELECT DATE_FORMAT(CURDATE(), '%Y-%m-01')
    ) months
    LEFT JOIN results ON DATE_FORMAT(results.attempted_at, '%Y-%m-01') = months.month_start
    GROUP BY months.month_start
    ORDER BY months.month_start
");
$chartRows = $chartStmt->fetchAll();

$recent = $pdo->query("
    SELECT r.*, s.name student_name, e.title exam_title
    FROM results r
    JOIN students s ON s.id = r.student_id
    JOIN exams e ON e.id = r.exam_id
    ORDER BY r.attempted_at DESC
    LIMIT 10
")->fetchAll();

include __DIR__ . '/../includes/header.php';
?>
<div class="row g-3 mb-4">
    <?php foreach ($stats as $label => $value): ?>
        <div class="col-md-6 col-xl-3">
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
                <h2 class="h5 mb-0">Exam Attempts</h2>
                <span class="text-secondary">Last 6 months</span>
            </div>
            <canvas id="attemptChart" height="110"></canvas>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="panel">
            <h2 class="h5 mb-3">Quick Actions</h2>
            <div class="d-grid gap-2">
                <a class="btn btn-primary" href="<?= e(url('modules/exams/add.php')) ?>">Add New Exam</a>
                <a class="btn btn-outline-primary" href="<?= e(url('modules/questions/add.php')) ?>">Add Question</a>
                <a class="btn btn-outline-primary" href="<?= e(url('modules/students/add.php')) ?>">Add Student</a>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="panel">
            <h2 class="h5 mb-3">Recent Results</h2>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Student</th><th>Exam</th><th>Score</th><th>Status</th><th>Attempted</th></tr></thead>
                    <tbody>
                    <?php foreach ($recent as $row): ?>
                        <tr>
                            <td><?= e($row['student_name']) ?></td>
                            <td><?= e($row['exam_title']) ?></td>
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
