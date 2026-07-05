<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    if (($_POST['action'] ?? '') === 'delete') {
        $stmt = $pdo->prepare('SELECT file_path FROM resources WHERE id = ?');
        $stmt->execute([(int) $_POST['id']]);
        $old = $stmt->fetchColumn();
        $pdo->prepare('DELETE FROM resources WHERE id = ?')->execute([(int) $_POST['id']]);
        if ($old) {
            $file = __DIR__ . '/../../../' . ltrim($old, '/');
            if (is_file($file)) { unlink($file); }
        }
        flash('success', 'Resource deleted.');
    } else {
        $filePath = null;
        if (!empty($_FILES['resource_file']['name'])) {
            $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'zip', 'jpg', 'jpeg', 'png'];
            $extension = strtolower(pathinfo($_FILES['resource_file']['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $allowed, true) || $_FILES['resource_file']['size'] > 20 * 1024 * 1024) {
                flash('error', 'Use PDF, Office, ZIP, JPG or PNG files up to 20 MB.');
                redirect('modules/resources/index.php');
            }
            $directory = __DIR__ . '/../../../storage/resources';
            if (!is_dir($directory)) { mkdir($directory, 0775, true); }
            $filename = bin2hex(random_bytes(10)) . '.' . $extension;
            if (!move_uploaded_file($_FILES['resource_file']['tmp_name'], $directory . '/' . $filename)) {
                flash('error', 'The resource could not be uploaded.');
                redirect('modules/resources/index.php');
            }
            $filePath = 'storage/resources/' . $filename;
        }
        $externalUrl = trim($_POST['external_url'] ?? '');
        if (!$filePath && !$externalUrl) {
            flash('error', 'Upload a file or provide an external URL.');
            redirect('modules/resources/index.php');
        }
        $pdo->prepare('INSERT INTO resources (subject_id, title, description, file_path, external_url) VALUES (?, ?, ?, ?, ?)')->execute([(int) $_POST['subject_id'], trim($_POST['title']), trim($_POST['description'] ?? ''), $filePath, $externalUrl ?: null]);
        flash('success', 'Learning resource uploaded.');
    }
    redirect('modules/resources/index.php');
}

$selectedSubject = (int) ($_GET['subject_id'] ?? 0);
$subjects = $pdo->query('SELECT s.id, s.name, c.name course_name FROM subjects s JOIN courses c ON c.id = s.course_id WHERE s.status = \'active\' ORDER BY c.name, s.name')->fetchAll();
$resources = $pdo->query('SELECT r.*, s.name subject_name, c.name course_name FROM resources r JOIN subjects s ON s.id = r.subject_id JOIN courses c ON c.id = s.course_id ORDER BY r.created_at DESC')->fetchAll();
$pageTitle = 'Notes & Resources'; $active = 'resources';
include __DIR__ . '/../../includes/header.php';
?>
<div class="row g-3"><div class="col-xl-4"><div class="panel"><h2 class="h5 mb-3">Upload Resource</h2><form method="post" enctype="multipart/form-data"><?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Subject</label><select class="form-select" name="subject_id" required><option value="">Select subject</option><?php foreach ($subjects as $subject): ?><option value="<?= e($subject['id']) ?>" <?= $selectedSubject === (int) $subject['id'] ? 'selected' : '' ?>><?= e($subject['course_name'] . ' — ' . $subject['name']) ?></option><?php endforeach; ?></select></div>
<div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title" required></div><div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="3"></textarea></div>
<div class="mb-3"><label class="form-label">File</label><input class="form-control" type="file" name="resource_file"><div class="form-text">PDF, Office, ZIP or image; maximum 20 MB.</div></div><div class="mb-3"><label class="form-label">Or external URL</label><input class="form-control" type="url" name="external_url" placeholder="https://..."></div><button class="btn btn-primary">Save Resource</button></form></div></div>
<div class="col-xl-8"><div class="panel"><h2 class="h5 mb-3">All Resources</h2><div class="table-responsive"><table class="table table-hover align-middle data-table"><thead><tr><th>Resource</th><th>Course / Subject</th><th>Type</th><th>Added</th><th>Actions</th></tr></thead><tbody><?php foreach ($resources as $resource): ?><tr><td><strong><?= e($resource['title']) ?></strong><div class="small text-secondary"><?= e($resource['description']) ?></div></td><td><?= e($resource['course_name']) ?><br><span class="text-secondary"><?= e($resource['subject_name']) ?></span></td><td><?= $resource['file_path'] ? 'File' : 'Link' ?></td><td><?= e(format_date($resource['created_at'])) ?></td><td class="table-actions"><?php $target = $resource['file_path'] ? site_url($resource['file_path']) : $resource['external_url']; ?><a class="btn btn-sm btn-outline-primary" href="<?= e($target) ?>" target="_blank">Open</a> <form class="d-inline" method="post"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($resource['id']) ?>"><button class="btn btn-sm btn-outline-danger js-delete">Delete</button></form></td></tr><?php endforeach; ?></tbody></table></div></div></div></div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
