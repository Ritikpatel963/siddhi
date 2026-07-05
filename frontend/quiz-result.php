<?php
require_once __DIR__ . '/includes/auth_check.php';
$result = $_SESSION['quiz_result'] ?? null; unset($_SESSION['quiz_result']);
if (!$result) { header('Location: ' . site_url('frontend/dashboard.php')); exit; }
$studentPageTitle = 'Quiz Result'; include __DIR__ . '/includes/header.php';
?>
<section class="result-card <?= e($result['status']) ?>"><span class="result-icon"><?= $result['status'] === 'pass' ? '✓' : '!' ?></span><p class="eyebrow"><?= e(strtoupper($result['status'])) ?></p><h1><?= e($result['quiz']) ?></h1><div class="result-score"><?= e($result['score']) ?><span>/<?= e($result['total']) ?></span></div><p><?= $result['status'] === 'pass' ? 'Nicely done. Your result has been saved.' : 'Keep going—review the study material and try again.' ?></p><a class="button" href="<?= e(site_url('frontend/dashboard.php')) ?>">Return to study plan</a></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
