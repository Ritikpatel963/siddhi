<?php $pageTitle = 'My Courses';
$active = 'courses';
include __DIR__ . '/includes/header.php'; ?>
<div class="page-head">
    <div>
        <h2>My Courses</h2>
        <p>Purchased and assigned courses.</p>
    </div>
</div>
<div class="card-grid"><?php foreach ($courses as $course): ?><article class="course-card"><span class="badge available"><?= e($course['status']) ?></span>
            <h3><?= e($course['title']) ?></h3>
            <p><?= e($course['subject']) ?></p>
            <div class="progress-line"><span style="width:<?= e($course['progress']) ?>%"></span></div>
            <div class="card-meta"><span><?= e($course['completed']) ?>/<?= e($course['lessons']) ?> lessons</span><span>Valid till <?= e($course['valid']) ?></span></div><a class="btn-secondary" href="<?= e(student_url('resources.php')) ?>">Open Resources</a>
        </article><?php endforeach; ?></div>
<?php include __DIR__ . '/includes/footer.php'; ?>