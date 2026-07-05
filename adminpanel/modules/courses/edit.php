<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM courses WHERE id = ?');
$stmt->execute([$id]);
$course = $stmt->fetch();

if (!$course) {
    flash('error', 'Course not found.');
    redirect('modules/courses/list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('UPDATE courses SET name = ?, description = ?, status = ? WHERE id = ?');
    $stmt->execute([trim($_POST['name']), trim($_POST['description']), $_POST['status'], $id]);
    flash('success', 'Course updated.');
    redirect('modules/courses/list.php');
}

$pageTitle = 'Edit Course';
$active = 'courses';
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/form.php';
include __DIR__ . '/../../includes/footer.php';
