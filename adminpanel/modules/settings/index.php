<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $settings = [
        'site_name' => trim($_POST['site_name']),
        'timezone' => trim($_POST['timezone']),
        'pagination_size' => (string) max(5, (int) $_POST['pagination_size']),
    ];
    $stmt = $pdo->prepare('INSERT INTO app_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
    foreach ($settings as $key => $value) {
        $stmt->execute([$key, $value]);
    }
    flash('success', 'Settings saved.');
    redirect('modules/settings/index.php');
}

$pageTitle = 'Settings';
$active = 'settings';
$siteName = setting($pdo, 'site_name', 'myExam Pre');
$timezone = setting($pdo, 'timezone', 'Asia/Kolkata');
$pagination = setting($pdo, 'pagination_size', '10');
include __DIR__ . '/../../includes/header.php';
?>
<div class="panel col-xl-6">
    <form method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Site Name</label>
            <input class="form-control" name="site_name" value="<?= e($siteName) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Timezone</label>
            <select class="form-select" name="timezone">
                <?php foreach (['Asia/Kolkata', 'UTC', 'Asia/Dubai', 'Asia/Singapore'] as $zone): ?>
                    <option value="<?= e($zone) ?>" <?= $timezone === $zone ? 'selected' : '' ?>><?= e($zone) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Pagination Size</label>
            <input class="form-control" type="number" name="pagination_size" value="<?= e($pagination) ?>" min="5" max="100" required>
        </div>
        <button class="btn btn-primary">Save Settings</button>
        <?php if (($_SESSION['role'] ?? '') === 'super_admin'): ?>
            <a class="btn btn-outline-secondary" href="<?= e(url('auth/register.php')) ?>">Create Admin</a>
        <?php endif; ?>
    </form>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
