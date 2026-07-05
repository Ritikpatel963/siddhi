<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../adminpanel/includes/functions.php';
if (!empty($_SESSION['student_id'])) { header('Location: ' . site_url('frontend/dashboard.php')); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf(site_url('auth/student'));
    $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ? AND status = 'active' LIMIT 1");
    $stmt->execute([trim($_POST['email'] ?? '')]); $student = $stmt->fetch();
    if ($student && password_verify($_POST['password'] ?? '', $student['password'])) {
        session_regenerate_id(true); $_SESSION['student_id'] = $student['id']; $_SESSION['student_name'] = $student['name']; header('Location: ' . site_url('frontend/dashboard.php')); exit;
    }
    flash('error', 'Invalid email or password.');
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Student Login | myExam Pre</title><link rel="stylesheet" href="<?= e(site_url('frontend/assets/css/style.css')) ?>"></head><body class="student-auth"><form class="login-card" method="post"><?= csrf_field() ?><a class="student-brand" href="<?= e(site_url()) ?>"><span>mE</span> myExam Pre</a><p class="eyebrow">Student portal</p><h1>Continue learning</h1><?php if ($error = flash('error')): ?><div class="message error"><?= e($error) ?></div><?php endif; ?><label>Email address<input type="email" name="email" required autofocus></label><label>Password<input type="password" name="password" required></label><button class="button login-button">Sign in</button><a class="back-link" href="<?= e(site_url()) ?>">← Back to website</a></form></body></html>
