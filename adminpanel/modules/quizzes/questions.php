<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/data.php';
$pageTitle = 'Question Builder / Bank';
$active = 'quizzes';
$totalMarks = array_sum(array_column($questions, 'marks'));
include __DIR__ . '/../../includes/header.php';
?>
<div class="quiz-page">
    <div class="quiz-toolbar">
        <div><h2>Question Builder / Bank</h2><p>Select a quiz, then add questions and options to that quiz.</p></div>
        <a class="btn btn-outline-secondary" href="<?= e(url('modules/quizzes/index.php')) ?>"><i class="bi bi-arrow-left"></i> Back</a>
    </div>

    <div class="panel quiz-context-panel">
        <div class="row g-3 align-items-end">
            <div class="col-lg-5"><label class="form-label">Active Quiz</label><select class="form-select"><?php foreach ($quizzes as $quiz): ?><option><?= e($quiz['title']) ?></option><?php endforeach; ?></select></div>
            <div class="col-sm-6 col-lg-2"><label class="form-label">Course</label><input class="form-control" value="APC Written Assessment" readonly></div>
            <div class="col-sm-6 col-lg-2"><label class="form-label">Subject</label><input class="form-control" value="Quantitative Aptitude" readonly></div>
            <div class="col-sm-6 col-lg-1"><label class="form-label">Questions</label><input class="form-control" value="<?= count($questions) ?>" readonly></div>
            <div class="col-sm-6 col-lg-1"><label class="form-label">Marks</label><input class="form-control" value="<?= e($totalMarks) ?>" readonly></div>
            <div class="col-lg-1"><a class="btn btn-primary w-100" href="#questionForm">Add</a></div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="panel" id="questionForm">
                <div class="d-flex justify-content-between gap-2 flex-wrap mb-3">
                    <div><h3 class="h5 mb-1">Add Question to Selected Quiz</h3><p class="text-secondary mb-0">Marks are per question. Negative marking is controlled once in Quiz Rules.</p></div>
                    <span class="quiz-badge active">Assigned to quiz</span>
                </div>
                <form action="#">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Question Type</label><select class="form-select"><option>Single Choice</option><option>Multiple Choice</option><option>True/False</option></select></div>
                        <div class="col-md-4"><label class="form-label">Difficulty</label><select class="form-select"><option>Easy</option><option selected>Medium</option><option>Hard</option></select></div>
                        <div class="col-md-4"><label class="form-label">Topic Tag</label><input class="form-control" value="Time & Distance"></div>
                        <div class="col-md-4"><label class="form-label">Marks for This Question</label><input class="form-control" type="number" value="2"></div>
                        <div class="col-md-8"><label class="form-label">Scoring Rule</label><input class="form-control" value="Correct +2, wrong -0.25 from quiz rule" readonly></div>
                        <div class="col-12"><label class="form-label">Question Text</label><textarea class="form-control" rows="4">A train crosses a 240m platform in 36 seconds and a pole in 20 seconds. What is the speed of the train?</textarea></div>
                        <div class="col-12"><label class="form-label">Question Image</label><input class="form-control" type="file"></div>
                        <?php foreach (['A' => '36 km/h', 'B' => '54 km/h', 'C' => '72 km/h', 'D' => '90 km/h', 'E optional' => ''] as $option => $value): ?>
                            <div class="col-md-6"><label class="form-label">Option <?= e($option) ?></label><input class="form-control" value="<?= e($value) ?>"></div>
                        <?php endforeach; ?>
                        <div class="col-md-4"><label class="form-label">Correct Answer</label><select class="form-select"><option>A</option><option selected>B</option><option>C</option><option>D</option><option>E</option></select></div>
                        <div class="col-md-8"><label class="form-label">Reference / Notes</label><input class="form-control" value="Chapter 4, Speed-Time-Distance practice set"></div>
                        <div class="col-12"><label class="form-label">Explanation</label><textarea class="form-control" rows="3">Platform crossing gives train length plus 240m; pole crossing gives train length. The difference is covered in 16 seconds.</textarea></div>
                    </div>
                    <div class="quiz-button-row mt-3">
                        <button class="btn btn-primary" type="button">Save Question</button>
                        <button class="btn btn-outline-secondary" type="button">Add Another Question</button>
                        <button class="btn btn-outline-secondary" type="button">Clear Form</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="panel mb-3">
                <div class="form-section-title">Assigned Question Summary</div>
                <div class="quiz-summary-grid mt-2">
                    <div><strong><?= count($questions) ?></strong><span>Questions in Quiz</span></div>
                    <div><strong><?= e($totalMarks) ?></strong><span>Total Marks</span></div>
                </div>
            </div>
            <div class="panel question-side-list">
                <h3 class="h5 mb-3">Questions Assigned to This Quiz</h3>
                <?php foreach ($questions as $index => $question): ?>
                    <div class="question-item" draggable="true">
                        <span class="q-num-badge"><?= $index + 1 ?></span>
                        <div><strong><?= e($question['topic']) ?></strong><p><?= e($question['difficulty']) ?> | <?= e($question['marks']) ?> marks | Answer <?= e($question['answer']) ?></p></div>
                        <div class="q-mini-actions"><button title="Edit" type="button"><i class="bi bi-pencil"></i></button><button title="Duplicate" type="button"><i class="bi bi-copy"></i></button><button title="Delete" type="button"><i class="bi bi-trash"></i></button></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
