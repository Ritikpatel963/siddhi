<?php
require_once __DIR__ . '/../includes/functions.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password | myExam Pre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= e(url('assets/css/style.css')) ?>" rel="stylesheet">
</head>
<body class="auth-page">
    <div class="auth-card">
        <h1 class="h4 fw-bold">Forgot Password</h1>
        <p class="text-secondary">Password reset emails are not configured for local XAMPP. Ask a super admin to update your password from the database or profile module.</p>
        <a class="btn btn-primary" href="<?= e(url('auth/login.php')) ?>">Back to Login</a>
    </div>
</body>
</html>
