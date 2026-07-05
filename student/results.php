<?php $pageTitle = 'Quiz Results';
$active = 'results';
include __DIR__ . '/includes/header.php'; ?>
<div class="page-head">
    <div>
        <h2>Quiz Results</h2>
        <p>Your latest scores and attempt history.</p>
    </div>
</div>
<div class="stat-grid compact">
    <div class="stat-card"><strong>3</strong><span>Attempts</span></div>
    <div class="stat-card"><strong>2</strong><span>Passed</span></div>
    <div class="stat-card"><strong>74%</strong><span>Average</span></div>
</div>
<div class="panel">
    <table class="student-table">
        <thead>
            <tr>
                <th>Quiz</th>
                <th>Course</th>
                <th>Score</th>
                <th>Percentage</th>
                <th>Status</th>
                <th>Time</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody><?php foreach ($results as $result): ?><tr>
                    <td><strong><?= e($result['quiz']) ?></strong></td>
                    <td><?= e($result['course']) ?></td>
                    <td><?= e($result['score']) ?></td>
                    <td><?= e($result['percent']) ?></td>
                    <td><span class="badge <?= $result['status'] === 'Passed' ? 'available' : 'warning' ?>"><?= e($result['status']) ?></span></td>
                    <td><?= e($result['time']) ?></td>
                    <td><?= e($result['date']) ?></td>
                </tr><?php endforeach; ?></tbody>
    </table>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>