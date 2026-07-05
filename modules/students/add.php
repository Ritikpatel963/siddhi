<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('INSERT INTO students (name, email, phone, password, status) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([trim($_POST['name']), trim($_POST['email']), trim($_POST['phone']), password_hash($_POST['password'], PASSWORD_BCRYPT), $_POST['status']]);
    flash('success', 'Student added.');
    redirect('modules/students/list.php');
}

$pageTitle = 'Add Student';
$active = 'students';
$student = ['name' => '', 'email' => '', 'phone' => '', 'status' => 'active'];
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/form.php';
include __DIR__ . '/../../includes/footer.php';
