<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';
$studentId = (int) ($_GET['student_id'] ?? 0);
$sql = 'SELECT qa.*, s.name student_name, s.email student_email, q.title quiz_title, sub.name subject_name, c.name course_name FROM quiz_attempts qa JOIN students s ON s.id = qa.student_id JOIN quizzes q ON q.id = qa.quiz_id JOIN subjects sub ON sub.id = q.subject_id JOIN courses c ON c.id = sub.course_id';
if ($studentId) { $sql .= ' WHERE qa.student_id = ' . $studentId; }
$results = $pdo->query($sql . ' ORDER BY qa.attempted_at DESC')->fetchAll();
$pageTitle = 'Quiz Results'; $active = 'quiz-results'; include __DIR__ . '/../../includes/header.php';
?>
<div class="panel"><h2 class="h5 mb-3">Student Attempts</h2><div class="table-responsive"><table class="table table-hover align-middle data-table"><thead><tr><th>Student</th><th>Course / Subject</th><th>Quiz</th><th>Score</th><th>Status</th><th>Attempted</th></tr></thead><tbody><?php foreach ($results as $result): ?><tr><td><strong><?= e($result['student_name']) ?></strong><div class="small text-secondary"><?= e($result['student_email']) ?></div></td><td><?= e($result['course_name']) ?><div class="small text-secondary"><?= e($result['subject_name']) ?></div></td><td><?= e($result['quiz_title']) ?></td><td><?= e($result['score']) ?>/<?= e($result['total_marks']) ?></td><td><?= status_badge($result['status']) ?></td><td><?= e(format_date($result['attempted_at'])) ?></td></tr><?php endforeach; ?><?php if (!$results): ?><tr><td colspan="6" class="text-center text-secondary">No quiz attempts yet.</td></tr><?php endif; ?></tbody></table></div></div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
