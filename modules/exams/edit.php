<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM exams WHERE id = ?');
$stmt->execute([$id]);
$exam = $stmt->fetch();
if (!$exam) {
    flash('error', 'Exam not found.');
    redirect('modules/exams/list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('UPDATE exams SET category_id = ?, title = ?, description = ?, duration_minutes = ?, total_marks = ?, passing_marks = ?, status = ? WHERE id = ?');
    $stmt->execute([
        $_POST['category_id'] ?: null,
        trim($_POST['title']),
        trim($_POST['description']),
        (int) $_POST['duration_minutes'],
        (int) $_POST['total_marks'],
        (int) $_POST['passing_marks'],
        $_POST['status'],
        $id,
    ]);
    flash('success', 'Exam updated.');
    redirect('modules/exams/list.php');
}

$pageTitle = 'Edit Exam';
$active = 'exams';
$categories = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/form.php';
include __DIR__ . '/../../includes/footer.php';
