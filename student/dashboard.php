<?php $pageTitle = 'Student Dashboard'; $active = 'dashboard'; include __DIR__ . '/includes/header.php'; ?>
<div class="welcome-band">
    <div><span class="eyebrow">Welcome back</span><h2><?= e($student['name']) ?></h2><p>Continue your courses, download resources, attempt quizzes, and track results.</p></div>
    <a class="btn-primary" href="<?= e(student_url('quizzes.php')) ?>">Start Quiz</a>
</div>
<div class="stat-grid">
    <div class="stat-card"><strong>3</strong><span>Active Courses</span></div>
    <div class="stat-card"><strong>12</strong><span>Resources</span></div>
    <div class="stat-card"><strong>5</strong><span>Quizzes Due</span></div>
    <div class="stat-card"><strong>74%</strong><span>Average Score</span></div>
</div>
<div class="content-grid">
    <section class="panel wide"><div class="section-head"><h3>My Courses</h3><a href="<?= e(student_url('courses.php')) ?>">View all</a></div><?php foreach ($courses as $course): ?><article class="course-row"><div><strong><?= e($course['title']) ?></strong><p><?= e($course['subject']) ?> · <?= e($course['completed']) ?>/<?= e($course['lessons']) ?> lessons</p></div><div class="progress-line"><span style="width:<?= e($course['progress']) ?>%"></span></div><b><?= e($course['progress']) ?>%</b></article><?php endforeach; ?></section>
    <section class="panel"><div class="section-head"><h3>Upcoming Quiz</h3></div><div class="quiz-callout"><span class="badge available">Available</span><h4><?= e($quizzes[0]['title']) ?></h4><p><?= e($quizzes[0]['questions']) ?> questions · <?= e($quizzes[0]['time']) ?> min</p><a class="btn-primary" href="<?= e(student_url('quiz.php')) ?>">Attempt Now</a></div></section>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
