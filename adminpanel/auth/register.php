<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if (($_SESSION['role'] ?? '') !== 'super_admin') {
    flash('error', 'Only super admins can create admin users.');
    redirect('modules/dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $stmt = $pdo->prepare('INSERT INTO admins (name, email, password, role) VALUES (?, ?, ?, ?)');
    $stmt->execute([
        trim($_POST['name']),
        trim($_POST['email']),
        password_hash($_POST['password'], PASSWORD_BCRYPT),
        $_POST['role'] === 'super_admin' ? 'super_admin' : 'admin',
    ]);
    flash('success', 'Admin user created.');
    redirect('auth/register.php');
}

$pageTitle = 'Create Admin';
$active = 'settings';
include __DIR__ . '/../includes/header.php';
?>
<div class="panel col-lg-6">
    <form method="post">
        <?= csrf_field() ?>
        <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required></div>
        <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required minlength="6"></div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select class="form-select" name="role">
                <option value="admin">Admin</option>
                <option value="super_admin">Super Admin</option>
            </select>
        </div>
        <button class="btn btn-primary">Create Admin</button>
    </form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
