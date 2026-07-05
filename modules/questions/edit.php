<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM questions WHERE id = ?');
$stmt->execute([$id]);
$question = $stmt->fetch();
if (!$question) {
    flash('error', 'Question not found.');
    redirect('modules/questions/list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('UPDATE questions SET exam_id = ?, question_text = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_option = ?, marks = ? WHERE id = ?');
    $stmt->execute([(int) $_POST['exam_id'], trim($_POST['question_text']), trim($_POST['option_a']), trim($_POST['option_b']), trim($_POST['option_c']), trim($_POST['option_d']), $_POST['correct_option'], (int) $_POST['marks'], $id]);
    flash('success', 'Question updated.');
    redirect('modules/questions/list.php?exam_id=' . (int) $_POST['exam_id']);
}

$pageTitle = 'Edit Question';
$active = 'questions';
$exams = $pdo->query('SELECT id, title FROM exams ORDER BY title')->fetchAll();
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/form.php';
include __DIR__ . '/../../includes/footer.php';
