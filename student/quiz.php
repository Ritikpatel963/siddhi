<?php require_once __DIR__ . '/data.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($quizzes[0]['title']) ?> | myExam Pre</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(student_url('assets/css/style.css')) ?>">
</head>
<body class="test-page">
<div class="test-shell">
    <header class="test-topbar">
        <a class="student-brand" href="<?= e(student_url('dashboard.php')) ?>"><span>mE</span><strong>myExam Pre</strong></a>
        <strong><?= e($quizzes[0]['title']) ?></strong>
        <div class="test-top-actions"><button class="btn-secondary" type="button">Instructions</button><a class="btn-danger" href="<?= e(student_url('results.php')) ?>">End Test</a></div>
    </header>

    <div class="test-main">
        <aside class="test-left">
            <div class="section-head"><h3>Questions</h3><span>30</span></div>
            <div class="legend"><span><i class="dot answered"></i>Answered</span><span><i class="dot marked"></i>Marked</span></div>
            <div class="q-grid"><?php for ($i = 1; $i <= 30; $i++): ?><button class="q-pill <?= $i === 1 ? 'current' : ($i < 6 ? 'answered' : ($i === 9 ? 'marked' : '')) ?>" type="button"><?= $i ?></button><?php endfor; ?></div>
        </aside>

        <main class="test-center">
            <div class="question-top"><span>Question 1 of 30</span><button class="btn-secondary" id="markReview" type="button">Mark for Review</button></div>
            <div class="question-scroll">
                <span class="badge muted">Quantitative Aptitude</span>
                <h2><?= e($questions[0]['q']) ?></h2>
                <div class="test-options"><?php foreach ($questions[0]['options'] as $index => $option): ?><button class="test-option" type="button"><span><?= chr(65 + $index) ?></span><?= e($option) ?></button><?php endforeach; ?></div>
            </div>
            <div class="question-actions"><button class="btn-secondary" type="button">Previous</button><button class="btn-secondary" id="clearResponse" type="button">Clear Response</button><button class="btn-primary" type="button">Save & Next</button></div>
        </main>

        <aside class="test-right">
            <div class="timer-card"><span>Timer</span><strong>01:18:42</strong><div class="progress-line"><span style="width:66%"></span></div></div>
            <div class="timer-card"><span>Progress</span><strong>5 / 30</strong><p>Questions saved in this frontend preview.</p></div>
            <div class="timer-card"><span>Quick Actions</span><button class="btn-secondary full" type="button">Calculator</button><button class="btn-secondary full" type="button">Instructions</button></div>
        </aside>
    </div>

    <footer class="test-summary"><span><i class="dot answered"></i>Answered <b>5</b></span><span><i class="dot empty"></i>Not Answered <b>4</b></span><span><i class="dot marked"></i>Marked <b>1</b></span><span><i class="dot visited"></i>Not Visited <b>20</b></span><a class="btn-danger" href="<?= e(student_url('results.php')) ?>">Submit Test</a></footer>
</div>
<script>
document.querySelectorAll('.test-option').forEach(button => button.addEventListener('click', function () {
    document.querySelectorAll('.test-option').forEach(item => item.classList.remove('selected'));
    this.classList.add('selected');
}));
document.getElementById('clearResponse')?.addEventListener('click', () => document.querySelectorAll('.test-option').forEach(item => item.classList.remove('selected')));
document.getElementById('markReview')?.addEventListener('click', () => document.querySelector('.q-pill.current')?.classList.toggle('marked'));
</script>
</body>
</html>
