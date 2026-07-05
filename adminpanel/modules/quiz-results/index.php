<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../quizzes/data.php';
$pageTitle = 'Quiz Result / Attempts';
$active = 'quiz-results';
include __DIR__ . '/../../includes/header.php';
?>
<div class="quiz-page">
    <div class="quiz-toolbar"><div><h2>Quiz Result / Attempts</h2><p>Admin overview of quiz performance.</p></div></div>
    <div class="result-cards mb-3">
        <?php foreach ([['Total Assigned Students', 184], ['Attempted', 126], ['Not Attempted', 58], ['Passed', 104], ['Failed', 22], ['Average Score', '68%']] as $card): ?>
            <div class="stat-card"><div class="value"><?= e($card[1]) ?></div><div class="label"><?= e($card[0]) ?></div></div>
        <?php endforeach; ?>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead><tr><th>Student Name</th><th>Course</th><th>Quiz Title</th><th>Score</th><th>Percentage</th><th>Result Status</th><th>Time Taken</th><th>Attempt Date</th><th>Actions</th></tr></thead>
                <tbody><?php foreach ($attempts as $attempt): ?><tr><td><strong><?= e($attempt['student']) ?></strong></td><td><?= e($attempt['course']) ?></td><td><?= e($attempt['quiz']) ?></td><td><?= e($attempt['score']) ?></td><td><?= e($attempt['percent']) ?></td><td><?= quiz_badge($attempt['status']) ?></td><td><?= e($attempt['time']) ?></td><td><?= e($attempt['date']) ?></td><td class="table-actions"><a class="btn btn-sm btn-primary" href="<?= e(url('modules/quiz-results/attempt-review.php')) ?>">View Attempt</a><button class="btn btn-sm btn-outline-secondary" type="button">Download Result</button><button class="btn btn-sm btn-outline-danger" type="button">Reset Attempt</button></td></tr><?php endforeach; ?></tbody>
            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
