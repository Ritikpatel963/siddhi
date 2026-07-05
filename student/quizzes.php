<?php $pageTitle = 'Quizzes';
$active = 'quizzes';
include __DIR__ . '/includes/header.php'; ?>
<div class="page-head">
    <div>
        <h2>Quizzes</h2>
        <p>Attempt assigned quizzes and mock tests.</p>
    </div><select class="search-box">
        <option>All Courses</option>
        <option>APC Written Assessment</option>
        <option>Reasoning Foundation</option>
    </select>
</div>
<div class="card-grid"><?php foreach ($quizzes as $quiz): ?><article class="quiz-card"><span class="badge <?= $quiz['status'] === 'Completed' ? 'completed' : 'available' ?>"><?= e($quiz['status']) ?></span>
            <h3><?= e($quiz['title']) ?></h3>
            <p><?= e($quiz['course']) ?> · <?= e($quiz['subject']) ?></p>
            <div class="quiz-meta"><span><?= e($quiz['questions']) ?> Questions</span><span><?= e($quiz['marks']) ?> Marks</span><span><?= e($quiz['time']) ?> Min</span><span><?= e($quiz['attempts']) ?> Attempts</span></div><a class="btn-primary" href="<?= e(student_url('quiz.php')) ?>"><?= $quiz['status'] === 'Completed' ? 'Review / Retake' : 'Start Quiz' ?></a>
        </article><?php endforeach; ?></div>
<?php include __DIR__ . '/includes/footer.php'; ?>