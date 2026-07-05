<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

$conditions = [];
$params = [];
foreach (['exam_id' => 'r.exam_id', 'student_id' => 'r.student_id', 'status' => 'r.status'] as $key => $column) {
    if (!empty($_GET[$key])) {
        $conditions[] = "$column = ?";
        $params[] = $_GET[$key];
    }
}
if (!empty($_GET['from_date'])) {
    $conditions[] = 'DATE(r.attempted_at) >= ?';
    $params[] = $_GET['from_date'];
}
if (!empty($_GET['to_date'])) {
    $conditions[] = 'DATE(r.attempted_at) <= ?';
    $params[] = $_GET['to_date'];
}
$where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';
$sql = "SELECT r.*, s.name student_name, e.title exam_title FROM results r JOIN students s ON s.id = r.student_id JOIN exams e ON e.id = r.exam_id $where ORDER BY r.attempted_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();

if (isset($_GET['export'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="results.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Student', 'Exam', 'Score', 'Total Marks', 'Status', 'Attempted At']);
    foreach ($results as $row) {
        fputcsv($out, [$row['student_name'], $row['exam_title'], $row['score'], $row['total_marks'], $row['status'], $row['attempted_at']]);
    }
    exit;
}

$pageTitle = 'Results';
$active = 'results';
$exams = $pdo->query('SELECT id, title FROM exams ORDER BY title')->fetchAll();
$students = $pdo->query('SELECT id, name FROM students ORDER BY name')->fetchAll();
include __DIR__ . '/../../includes/header.php';
?>
<div class="panel mb-3">
    <form class="row g-3 align-items-end" method="get">
        <div class="col-md-2"><label class="form-label">Exam</label><select class="form-select" name="exam_id"><option value="">All</option><?php foreach ($exams as $exam): ?><option value="<?= e($exam['id']) ?>" <?= ($_GET['exam_id'] ?? '') == $exam['id'] ? 'selected' : '' ?>><?= e($exam['title']) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-2"><label class="form-label">Student</label><select class="form-select" name="student_id"><option value="">All</option><?php foreach ($students as $student): ?><option value="<?= e($student['id']) ?>" <?= ($_GET['student_id'] ?? '') == $student['id'] ? 'selected' : '' ?>><?= e($student['name']) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-2"><label class="form-label">Status</label><select class="form-select" name="status"><option value="">All</option><option value="pass" <?= ($_GET['status'] ?? '') === 'pass' ? 'selected' : '' ?>>Pass</option><option value="fail" <?= ($_GET['status'] ?? '') === 'fail' ? 'selected' : '' ?>>Fail</option></select></div>
        <div class="col-md-2"><label class="form-label">From</label><input class="form-control" type="date" name="from_date" value="<?= e($_GET['from_date'] ?? '') ?>"></div>
        <div class="col-md-2"><label class="form-label">To</label><input class="form-control" type="date" name="to_date" value="<?= e($_GET['to_date'] ?? '') ?>"></div>
        <div class="col-md-2 d-flex gap-2"><button class="btn btn-primary">Filter</button><button class="btn btn-outline-secondary" name="export" value="1">CSV</button></div>
    </form>
</div>
<div class="panel">
    <table class="table table-hover align-middle data-table">
        <thead><tr><th>Student</th><th>Exam</th><th>Score</th><th>Status</th><th>Attempted</th></tr></thead>
        <tbody>
        <?php foreach ($results as $row): ?>
            <tr><td><?= e($row['student_name']) ?></td><td><?= e($row['exam_title']) ?></td><td><?= e($row['score']) ?>/<?= e($row['total_marks']) ?></td><td><?= status_badge($row['status']) ?></td><td><?= e(format_date($row['attempted_at'])) ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
