<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('DELETE FROM exams WHERE id = ?');
    $stmt->execute([(int) $_POST['id']]);
    flash('success', 'Exam deleted.');
    redirect('modules/exams/list.php');
}

$pageTitle = 'Exams';
$active = 'exams';
$exams = $pdo->query('
    SELECT exams.*, categories.name category_name
    FROM exams
    LEFT JOIN categories ON categories.id = exams.category_id
    ORDER BY exams.created_at DESC
')->fetchAll();
include __DIR__ . '/../../includes/header.php';
?>
<div class="panel">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">All Exams</h2>
        <a class="btn btn-primary" href="<?= e(url('modules/exams/add.php')) ?>">Add Exam</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle data-table">
            <thead><tr><th>Title</th><th>Category</th><th>Duration</th><th>Total Marks</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($exams as $exam): ?>
                <tr>
                    <td><?= e($exam['title']) ?></td>
                    <td><?= e($exam['category_name'] ?: '-') ?></td>
                    <td><?= e($exam['duration_minutes']) ?> min</td>
                    <td><?= e($exam['total_marks']) ?></td>
                    <td><?= status_badge($exam['status']) ?></td>
                    <td><?= e(format_date($exam['created_at'])) ?></td>
                    <td class="table-actions">
                        <a class="btn btn-sm btn-outline-primary" href="<?= e(url('modules/exams/edit.php?id=' . $exam['id'])) ?>">Edit</a>
                        <form class="d-inline" method="post">
                            <?= csrf_field() ?><input type="hidden" name="id" value="<?= e($exam['id']) ?>">
                            <button class="btn btn-sm btn-outline-danger js-delete" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
