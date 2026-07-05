<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_option, marks) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([(int) $_POST['exam_id'], trim($_POST['question_text']), trim($_POST['option_a']), trim($_POST['option_b']), trim($_POST['option_c']), trim($_POST['option_d']), $_POST['correct_option'], (int) $_POST['marks']]);
    flash('success', 'Question added.');
    redirect('modules/questions/list.php?exam_id=' . (int) $_POST['exam_id']);
}

$pageTitle = 'Add Question';
$active = 'questions';
$exams = $pdo->query('SELECT id, title FROM exams ORDER BY title')->fetchAll();
$question = ['exam_id' => (int) ($_GET['exam_id'] ?? 0), 'question_text' => '', 'option_a' => '', 'option_b' => '', 'option_c' => '', 'option_d' => '', 'correct_option' => 'A', 'marks' => 1];
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/form.php';
include __DIR__ . '/../../includes/footer.php';
