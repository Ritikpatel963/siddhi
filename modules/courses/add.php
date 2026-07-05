<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('INSERT INTO courses (name, description, status) VALUES (?, ?, ?)');
    $stmt->execute([trim($_POST['name']), trim($_POST['description']), $_POST['status']]);
    flash('success', 'Course added.');
    redirect('modules/courses/list.php');
}

$pageTitle = 'Add Course';
$active = 'courses';
$course = ['name' => '', 'description' => '', 'status' => 'active'];
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/form.php';
include __DIR__ . '/../../includes/footer.php';
