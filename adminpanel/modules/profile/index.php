<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

$adminId = (int) $_SESSION['admin_id'];
$stmt = $pdo->prepare('SELECT * FROM admins WHERE id = ?');
$stmt->execute([$adminId]);
$admin = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $imagePath = $admin['profile_image'];

    if (!empty($_FILES['profile_image']['name'])) {
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = mime_content_type($_FILES['profile_image']['tmp_name']);
        if (!isset($allowed[$mime]) || $_FILES['profile_image']['size'] > 2 * 1024 * 1024) {
            flash('error', 'Profile image must be JPG, PNG, or WebP and under 2MB.');
            redirect('modules/profile/index.php');
        }
        $filename = 'admin-' . $adminId . '-' . time() . '.' . $allowed[$mime];
        $destination = __DIR__ . '/../../assets/images/profiles/' . $filename;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination);
        $imagePath = 'assets/images/profiles/' . $filename;
    }

    $params = [$name, $email, $imagePath];
    $sql = 'UPDATE admins SET name = ?, email = ?, profile_image = ?';
    if (!empty($_POST['password'])) {
        $sql .= ', password = ?';
        $params[] = password_hash($_POST['password'], PASSWORD_BCRYPT);
    }
    $sql .= ' WHERE id = ?';
    $params[] = $adminId;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $_SESSION['admin_name'] = $name;
    flash('success', 'Profile updated.');
    redirect('modules/profile/index.php');
}

$pageTitle = 'Profile';
$active = 'profile';
include __DIR__ . '/../../includes/header.php';
?>
<div class="panel col-xl-7">
    <form method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="d-flex align-items-center gap-3 mb-4">
            <?php if ($admin['profile_image']): ?>
                <img class="rounded-circle" width="72" height="72" src="<?= e(url($admin['profile_image'])) ?>" alt="Profile">
            <?php else: ?>
                <span class="avatar" style="width:72px;height:72px;font-size:28px;"><?= e(strtoupper(substr($admin['name'], 0, 1))) ?></span>
            <?php endif; ?>
            <div>
                <div class="fw-bold"><?= e($admin['role']) ?></div>
                <div class="text-secondary"><?= e($admin['email']) ?></div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" value="<?= e($admin['name']) ?>" required></div>
            <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= e($admin['email']) ?>" required></div>
            <div class="col-md-6"><label class="form-label">Profile Picture</label><input class="form-control" type="file" name="profile_image" accept="image/png,image/jpeg,image/webp"></div>
            <div class="col-md-6"><label class="form-label">New Password</label><input class="form-control" type="password" name="password"></div>
        </div>
        <button class="btn btn-primary mt-4">Update Profile</button>
    </form>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
