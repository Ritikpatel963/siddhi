<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? 'create';
    if ($action === 'delete') {
        $pdo->prepare('DELETE FROM quizzes WHERE id = ?')->execute([(int) $_POST['id']]);
        flash('success', 'Quiz deleted.');
    } elseif ($action === 'status') {
        $pdo->prepare('UPDATE quizzes SET status = ? WHERE id = ?')->execute([$_POST['status'] === 'published' ? 'published' : 'draft', (int) $_POST['id']]);
        flash('success', 'Quiz status updated.');
    } else {
        $pdo->prepare('INSERT INTO quizzes (subject_id, title, duration_minutes, passing_marks, status) VALUES (?, ?, ?, ?, ?)')->execute([(int) $_POST['subject_id'], trim($_POST['title']), max(1, (int) $_POST['duration_minutes']), max(1, (int) $_POST['passing_marks']), $_POST['status'] === 'published' ? 'published' : 'draft']);
        flash('success', 'Quiz created. Add its questions now.');
    }
    redirect('modules/quizzes/index.php');
}
$selectedSubject = (int) ($_GET['subject_id'] ?? 0);
$subjects = $pdo->query('SELECT s.id, s.name, c.name course_name FROM subjects s JOIN courses c ON c.id = s.course_id WHERE s.status = \'active\' ORDER BY c.name, s.name')->fetchAll();
$quizzes = $pdo->query('SELECT q.*, s.name subject_name, c.name course_name, (SELECT COUNT(*) FROM quiz_questions qq WHERE qq.quiz_id = q.id) question_count, (SELECT COUNT(*) FROM quiz_attempts qa WHERE qa.quiz_id = q.id) attempt_count FROM quizzes q JOIN subjects s ON s.id = q.subject_id JOIN courses c ON c.id = s.course_id ORDER BY q.created_at DESC')->fetchAll();
$pageTitle = 'Quizzes'; $active = 'quizzes'; include __DIR__ . '/../../includes/header.php';
?>
<div class="row g-3"><div class="col-xl-4"><div class="panel"><h2 class="h5 mb-3">Create Quiz</h2><form method="post"><?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Subject</label><select class="form-select" name="subject_id" required><option value="">Select subject</option><?php foreach ($subjects as $subject): ?><option value="<?= e($subject['id']) ?>" <?= $selectedSubject === (int) $subject['id'] ? 'selected' : '' ?>><?= e($subject['course_name'] . ' — ' . $subject['name']) ?></option><?php endforeach; ?></select></div>
<div class="mb-3"><label class="form-label">Quiz title</label><input class="form-control" name="title" required></div><div class="row g-2"><div class="col-6 mb-3"><label class="form-label">Minutes</label><input class="form-control" type="number" min="1" name="duration_minutes" value="15" required></div><div class="col-6 mb-3"><label class="form-label">Pass marks</label><input class="form-control" type="number" min="1" name="passing_marks" value="1" required></div></div><div class="mb-3"><label class="form-label">Status</label><select class="form-select" name="status"><option value="draft">Draft</option><option value="published">Published</option></select></div><button class="btn btn-primary">Create Quiz</button></form></div></div>
<div class="col-xl-8"><div class="panel"><h2 class="h5 mb-3">All Quizzes</h2><div class="table-responsive"><table class="table table-hover align-middle data-table"><thead><tr><th>Quiz</th><th>Subject</th><th>Questions</th><th>Attempts</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php foreach ($quizzes as $quiz): ?><tr><td><strong><?= e($quiz['title']) ?></strong><div class="small text-secondary"><?= e($quiz['duration_minutes']) ?> minutes · pass <?= e($quiz['passing_marks']) ?></div></td><td><?= e($quiz['course_name']) ?><br><span class="text-secondary"><?= e($quiz['subject_name']) ?></span></td><td><?= e($quiz['question_count']) ?></td><td><?= e($quiz['attempt_count']) ?></td><td><?= status_badge($quiz['status']) ?></td><td class="table-actions"><a class="btn btn-sm btn-primary" href="<?= e(url('modules/quizzes/questions.php?quiz_id=' . $quiz['id'])) ?>">Questions</a> <form class="d-inline" method="post"><?= csrf_field() ?><input type="hidden" name="action" value="status"><input type="hidden" name="id" value="<?= e($quiz['id']) ?>"><input type="hidden" name="status" value="<?= $quiz['status'] === 'published' ? 'draft' : 'published' ?>"><button class="btn btn-sm btn-outline-secondary"><?= $quiz['status'] === 'published' ? 'Unpublish' : 'Publish' ?></button></form> <form class="d-inline" method="post"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($quiz['id']) ?>"><button class="btn btn-sm btn-outline-danger js-delete">Delete</button></form></td></tr><?php endforeach; ?></tbody></table></div></div></div></div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
