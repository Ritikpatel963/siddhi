<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';
$studentId = (int) $_SESSION['student_id']; $quizId = (int) ($_GET['id'] ?? $_POST['quiz_id'] ?? 0);
$stmt = $pdo->prepare("SELECT q.*, s.name subject_name, c.name course_name FROM quizzes q JOIN subjects s ON s.id = q.subject_id JOIN courses c ON c.id = s.course_id JOIN student_courses sc ON sc.course_id = c.id WHERE q.id = ? AND q.status = 'published' AND sc.student_id = ? LIMIT 1"); $stmt->execute([$quizId, $studentId]); $quiz = $stmt->fetch();
if (!$quiz) { header('Location: ' . site_url('frontend/dashboard.php')); exit; }
$stmt = $pdo->prepare('SELECT * FROM quiz_questions WHERE quiz_id = ? ORDER BY id'); $stmt->execute([$quizId]); $questions = $stmt->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf(site_url('frontend/quiz.php?id=' . $quizId)); $score = 0; $total = 0;
    foreach ($questions as $question) { $total += (int) $question['marks']; if (($_POST['answers'][$question['id']] ?? '') === $question['correct_option']) { $score += (int) $question['marks']; } }
    $status = $score >= (int) $quiz['passing_marks'] ? 'pass' : 'fail';
    $pdo->prepare('INSERT INTO quiz_attempts (student_id, quiz_id, score, total_marks, status) VALUES (?, ?, ?, ?, ?)')->execute([$studentId, $quizId, $score, $total, $status]);
    $_SESSION['quiz_result'] = ['score' => $score, 'total' => $total, 'status' => $status, 'quiz' => $quiz['title']]; header('Location: ' . site_url('frontend/quiz-result.php')); exit;
}
$studentPageTitle = $quiz['title']; include __DIR__ . '/includes/header.php';
?>
<section class="quiz-shell"><a class="back-link" href="<?= e(site_url('frontend/dashboard.php')) ?>">← Back to study plan</a><div class="quiz-heading"><span class="course-kicker"><?= e($quiz['course_name'] . ' · ' . $quiz['subject_name']) ?></span><h1><?= e($quiz['title']) ?></h1><p><?= e($quiz['duration_minutes']) ?> minutes · Passing marks: <?= e($quiz['passing_marks']) ?></p></div><?php if (!$questions): ?><div class="empty-state">This quiz has no questions yet.</div><?php else: ?><form method="post"><?= csrf_field() ?><input type="hidden" name="quiz_id" value="<?= e($quizId) ?>"><?php foreach ($questions as $index => $question): ?><fieldset class="question-card"><legend><?= $index + 1 ?>. <?= e($question['question_text']) ?> <small><?= e($question['marks']) ?> marks</small></legend><?php foreach (['A','B','C','D'] as $option): $key = 'option_' . strtolower($option); ?><label class="answer-option"><input type="radio" name="answers[<?= e($question['id']) ?>]" value="<?= $option ?>" required><span><strong><?= $option ?>.</strong> <?= e($question[$key]) ?></span></label><?php endforeach; ?></fieldset><?php endforeach; ?><button class="button submit-quiz">Submit quiz</button></form><?php endif; ?></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
