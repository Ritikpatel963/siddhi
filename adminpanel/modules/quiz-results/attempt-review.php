<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../quizzes/data.php';
$pageTitle = 'Student Attempt Review';
$active = 'quiz-results';
include __DIR__ . '/../../includes/header.php';
?>
<div class="quiz-page">
    <div class="quiz-toolbar"><div><h2>Student Attempt Review</h2><p>Question-wise answer review with scoring and explanations.</p></div><a class="btn btn-outline-secondary" href="<?= e(url('modules/quiz-results/index.php')) ?>">Back</a></div>
    <div class="row g-3 mb-3">
        <div class="col-md-4"><div class="card"><div class="form-section-title">Student Details</div><p class="mb-1"><strong>Aarav Sharma</strong></p><p class="text-secondary mb-0">aarav@example.com · +91 98765 44120</p></div></div>
        <div class="col-md-4"><div class="card"><div class="form-section-title">Quiz Details</div><p class="mb-1"><strong>Full Length Mock Test 01</strong></p><p class="text-secondary mb-0">APC Written Assessment · 120 minutes</p></div></div>
        <div class="col-md-4"><div class="card score-card"><div><span>Score Summary</span><strong>82 / 100</strong></div><?= quiz_badge('Passed') ?></div></div>
    </div>
    <div class="panel question-review-list">
        <?php foreach ($questions as $index => $question): $wrong = $index === 1; ?>
            <div class="review-question">
                <div class="review-head"><strong>Q<?= $index + 1 ?>. <?= e($question['q']) ?></strong><span><?= $wrong ? '0' : e($question['marks']) ?> / <?= e($question['marks']) ?> marks</span></div>
                <div class="review-options">
                    <?php foreach ($question['options'] as $optionIndex => $option): $letter = chr(65 + $optionIndex); $class = $letter === $question['answer'] ? 'correct' : ($wrong && $letter === 'C' ? 'wrong' : ''); ?>
                        <div class="review-option <?= e($class) ?>"><span><?= e($letter) ?></span><?= e($option) ?></div>
                    <?php endforeach; ?>
                </div>
                <div class="explain-box"><strong>Explanation:</strong> Solve from the given values and compare options. Correct answer is option <?= e($question['answer']) ?>.</div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
