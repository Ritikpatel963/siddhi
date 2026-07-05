<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!empty($_SESSION['admin_id'])) {
    redirect('modules/dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ? AND status = 'active' LIMIT 1");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['role'] = $admin['role'];
        redirect('modules/dashboard.php');
    }

    flash('error', 'Invalid email or password.');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | myExam Pre</title>
    <link rel="icon" href="<?= e(url('assets/images/favicon.svg')) ?>" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= e(url('assets/css/style.css')) ?>" rel="stylesheet">
</head>
<body class="auth-page">
    <form class="auth-card" method="post" autocomplete="off">
        <?= csrf_field() ?>
        <div class="text-center mb-4">
            <div class="brand-mark mx-auto mb-3">mE</div>
            <h1 class="h4 fw-bold mb-1">myExam Pre</h1>
            <p class="text-secondary mb-0">Admin dashboard login</p>
        </div>
        <?php if ($error = flash('error')): ?>
            <div class="alert alert-danger py-2"><?= e($error) ?></div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" type="email" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" name="password" type="password" required>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" id="remember" type="checkbox" name="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <a href="<?= e(url('auth/forgot-password.php')) ?>">Forgot Password?</a>
        </div>
        <button class="btn btn-primary w-100" type="submit">Login</button>
        <p class="text-secondary small text-center mt-3 mb-0">Default: admin@myexampre.com / Admin@123</p>
    </form>
</body>
</html>
