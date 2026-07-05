<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';
    if ($action === 'create') {
        $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->execute([trim($_POST['name'])]);
        flash('success', 'Category added.');
    } elseif ($action === 'update') {
        $stmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?');
        $stmt->execute([trim($_POST['name']), (int) $_POST['id']]);
        flash('success', 'Category updated.');
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->execute([(int) $_POST['id']]);
        flash('success', 'Category deleted.');
    }
    redirect('modules/categories/list.php');
}

$pageTitle = 'Categories';
$active = 'categories';
$categories = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
include __DIR__ . '/../../includes/header.php';
?>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="panel">
            <h2 class="h5 mb-3">Add Category</h2>
            <form method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="create">
                <label class="form-label">Name</label>
                <input class="form-control mb-3" name="name" required>
                <button class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="panel">
            <table class="table align-middle data-table">
                <thead><tr><th>Name</th><th>Created</th><th>Actions</th></tr></thead>
                <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td>
                            <form class="d-flex gap-2" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?= e($category['id']) ?>">
                                <input class="form-control" name="name" value="<?= e($category['name']) ?>" required>
                                <button class="btn btn-sm btn-outline-primary">Update</button>
                            </form>
                        </td>
                        <td><?= e(format_date($category['created_at'])) ?></td>
                        <td>
                            <form method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= e($category['id']) ?>">
                                <button class="btn btn-sm btn-outline-danger js-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
