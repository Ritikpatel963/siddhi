<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
    $stmt->execute([(int) $_POST['id']]);
    flash('success', 'Student deleted.');
    redirect('modules/students/list.php');
}

$pageTitle = 'Students';
$active = 'students';
$students = $pdo->query('SELECT s.*, GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR \' · \') course_names FROM students s LEFT JOIN student_courses sc ON sc.student_id = s.id LEFT JOIN courses c ON c.id = sc.course_id GROUP BY s.id ORDER BY s.created_at DESC')->fetchAll();
include __DIR__ . '/../../includes/header.php';
?>
<div class="panel">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">All Students</h2>
        <a class="btn btn-primary" href="<?= e(url('modules/students/add.php')) ?>">Add Student</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle data-table">
            <thead><tr><th>Name</th><th>Email</th><th>Courses</th><th>Phone</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= e($student['name']) ?></td>
                    <td><?= e($student['email']) ?></td>
                    <td><?= e($student['course_names'] ?: 'Not enrolled') ?></td>
                    <td><?= e($student['phone']) ?></td>
                    <td><?= status_badge($student['status']) ?></td>
                    <td><?= e(format_date($student['created_at'])) ?></td>
                    <td class="table-actions">
                        <a class="btn btn-sm btn-outline-secondary" href="<?= e(url('modules/quiz-results/index.php?student_id=' . $student['id'])) ?>">History</a>
                        <a class="btn btn-sm btn-outline-primary" href="<?= e(url('modules/students/edit.php?id=' . $student['id'])) ?>">Edit</a>
                        <form class="d-inline" method="post">
                            <?= csrf_field() ?><input type="hidden" name="id" value="<?= e($student['id']) ?>">
                            <button class="btn btn-sm btn-outline-danger js-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
