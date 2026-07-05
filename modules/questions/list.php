<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    if (($_POST['action'] ?? '') === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM questions WHERE id = ?');
        $stmt->execute([(int) $_POST['id']]);
        flash('success', 'Question deleted.');
    } elseif (($_POST['action'] ?? '') === 'import' && isset($_FILES['csv_file'])) {
        $examId = (int) $_POST['exam_id'];
        $file = $_FILES['csv_file']['tmp_name'];
        if ($examId && is_uploaded_file($file)) {
            $handle = fopen($file, 'r');
            $stmt = $pdo->prepare('INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_option, marks) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 7 || strtolower($row[0]) === 'question_text') {
                    continue;
                }
                $stmt->execute([$examId, $row[0], $row[1], $row[2], $row[3], $row[4], strtoupper($row[5]), (int) $row[6]]);
            }
            fclose($handle);
            flash('success', 'Questions imported.');
        }
    }
    redirect('modules/questions/list.php?exam_id=' . (int) ($_POST['exam_id'] ?? 0));
}

$pageTitle = 'Questions';
$active = 'questions';
$examId = (int) ($_GET['exam_id'] ?? 0);
$exams = $pdo->query('SELECT id, title FROM exams ORDER BY title')->fetchAll();
$questions = [];
if ($examId) {
    $stmt = $pdo->prepare('SELECT q.*, e.title exam_title FROM questions q JOIN exams e ON e.id = q.exam_id WHERE q.exam_id = ? ORDER BY q.id DESC');
    $stmt->execute([$examId]);
    $questions = $stmt->fetchAll();
} else {
    $questions = $pdo->query('SELECT q.*, e.title exam_title FROM questions q JOIN exams e ON e.id = q.exam_id ORDER BY q.id DESC')->fetchAll();
}
include __DIR__ . '/../../includes/header.php';
?>
<div class="panel mb-3">
    <div class="row g-3 align-items-end">
        <div class="col-md-5">
            <form method="get">
                <label class="form-label">Filter by Exam</label>
                <div class="input-group">
                    <select class="form-select" name="exam_id">
                        <option value="0">All exams</option>
                        <?php foreach ($exams as $exam): ?>
                            <option value="<?= e($exam['id']) ?>" <?= $examId === (int) $exam['id'] ? 'selected' : '' ?>><?= e($exam['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-outline-primary">Filter</button>
                </div>
            </form>
        </div>
        <div class="col-md-3">
            <a class="btn btn-primary w-100" href="<?= e(url('modules/questions/add.php' . ($examId ? '?exam_id=' . $examId : ''))) ?>">Add Question</a>
        </div>
        <div class="col-md-4">
            <form class="d-flex gap-2" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="import">
                <input type="hidden" name="exam_id" value="<?= e($examId) ?>">
                <input class="form-control" type="file" name="csv_file" accept=".csv" <?= $examId ? '' : 'disabled' ?>>
                <button class="btn btn-outline-secondary" <?= $examId ? '' : 'disabled' ?>>Import</button>
            </form>
        </div>
    </div>
</div>
<div class="panel">
    <div class="table-responsive">
        <table class="table table-hover align-middle data-table">
            <thead><tr><th>Exam</th><th>Question</th><th>Correct</th><th>Marks</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?= e($question['exam_title']) ?></td>
                    <td><?= e(strlen($question['question_text']) > 90 ? substr($question['question_text'], 0, 87) . '...' : $question['question_text']) ?></td>
                    <td><?= e($question['correct_option']) ?></td>
                    <td><?= e($question['marks']) ?></td>
                    <td class="table-actions">
                        <a class="btn btn-sm btn-outline-primary" href="<?= e(url('modules/questions/edit.php?id=' . $question['id'])) ?>">Edit</a>
                        <form class="d-inline" method="post">
                            <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($question['id']) ?>"><input type="hidden" name="exam_id" value="<?= e($question['exam_id']) ?>">
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

