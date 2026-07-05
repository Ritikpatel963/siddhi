<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    if (($_POST['action'] ?? '') === 'delete') {
        $pdo->prepare('DELETE FROM subjects WHERE id = ?')->execute([(int) $_POST['id']]);
        flash('success', 'Subject deleted.');
    } else {
        $pdo->prepare('INSERT INTO subjects (course_id, name, description, status) VALUES (?, ?, ?, ?)')->execute([
            (int) $_POST['course_id'], trim($_POST['name']), trim($_POST['description'] ?? ''), $_POST['status'] === 'inactive' ? 'inactive' : 'active'
        ]);
        flash('success', 'Subject added to the course.');
    }
    redirect('modules/subjects/index.php');
}

$courses = $pdo->query('SELECT id, name FROM courses WHERE status = \'active\' ORDER BY name')->fetchAll();
$subjects = $pdo->query('SELECT s.*, c.name course_name, (SELECT COUNT(*) FROM resources r WHERE r.subject_id = s.id) resource_count, (SELECT COUNT(*) FROM quizzes q WHERE q.subject_id = s.id) quiz_count FROM subjects s JOIN courses c ON c.id = s.course_id ORDER BY c.name, s.name')->fetchAll();
$pageTitle = 'Subjects';
$active = 'subjects';
include __DIR__ . '/../../includes/header.php';
?>
<div class="row g-3">
    <div class="col-xl-4">
        <div class="panel">
            <h2 class="h5 mb-3">Add Subject</h2>
            <?php if (!$courses): ?><div class="alert alert-warning">Create an active course first.</div><?php endif; ?>
            <form method="post">
                <?= csrf_field() ?>
                <div class="mb-3"><label class="form-label">Course</label><select class="form-select" name="course_id" required><option value="">Select course</option><?php foreach ($courses as $course): ?><option value="<?= e($course['id']) ?>"><?= e($course['name']) ?></option><?php endforeach; ?></select></div>
                <div class="mb-3"><label class="form-label">Subject name</label><input class="form-control" name="name" required></div>
                <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="3"></textarea></div>
                <div class="mb-3"><label class="form-label">Status</label><select class="form-select" name="status"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
                <button class="btn btn-primary" <?= !$courses ? 'disabled' : '' ?>>Add Subject</button>
            </form>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="panel">
            <h2 class="h5 mb-3">Course Subjects</h2>
            <div class="table-responsive"><table class="table table-hover align-middle data-table"><thead><tr><th>Subject</th><th>Course</th><th>Resources</th><th>Quizzes</th><th>Status</th><th>Actions</th></tr></thead><tbody>
            <?php foreach ($subjects as $subject): ?><tr>
                <td><strong><?= e($subject['name']) ?></strong><div class="small text-secondary"><?= e($subject['description']) ?></div></td>
                <td><?= e($subject['course_name']) ?></td><td><?= e($subject['resource_count']) ?></td><td><?= e($subject['quiz_count']) ?></td><td><?= status_badge($subject['status']) ?></td>
                <td class="table-actions"><a class="btn btn-sm btn-outline-primary" href="<?= e(url('modules/resources/index.php?subject_id=' . $subject['id'])) ?>">Resources</a> <a class="btn btn-sm btn-outline-primary" href="<?= e(url('modules/quizzes/index.php?subject_id=' . $subject['id'])) ?>">Quizzes</a> <form class="d-inline" method="post"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($subject['id']) ?>"><button class="btn btn-sm btn-outline-danger js-delete">Delete</button></form></td>
            </tr><?php endforeach; ?>
            </tbody></table></div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
