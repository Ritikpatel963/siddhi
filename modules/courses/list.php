<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('DELETE FROM courses WHERE id = ?');
    $stmt->execute([(int) $_POST['id']]);
    flash('success', 'Course deleted.');
    redirect('modules/courses/list.php');
}

$pageTitle = 'Courses';
$active = 'courses';
$courses = $pdo->query('SELECT * FROM courses ORDER BY created_at DESC')->fetchAll();
include __DIR__ . '/../../includes/header.php';
?>
<div class="panel">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">All Courses</h2>
        <a class="btn btn-primary" href="<?= e(url('modules/courses/add.php')) ?>">Add Course</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle data-table">
            <thead>
                <tr><th>Course</th><th>Description</th><th>Status</th><th>Created</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= e($course['name']) ?></td>
                    <td><?= e(strlen($course['description'] ?? '') > 90 ? substr($course['description'], 0, 87) . '...' : ($course['description'] ?? '-')) ?></td>
                    <td><?= status_badge($course['status']) ?></td>
                    <td><?= e(format_date($course['created_at'])) ?></td>
                    <td class="table-actions">
                        <a class="btn btn-sm btn-outline-primary" href="<?= e(url('modules/courses/edit.php?id=' . $course['id'])) ?>">Edit</a>
                        <form class="d-inline" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= e($course['id']) ?>">
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
