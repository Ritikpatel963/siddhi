<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/data.php';
$pageTitle = 'Create / Edit Quiz';
$active = 'quizzes';
include __DIR__ . '/../../includes/header.php';
?>
<div class="quiz-page">
    <div class="quiz-toolbar">
        <div><h2>Create / Edit Quiz</h2><p>Set the quiz shell first. Question count and total marks come from the assigned questions.</p></div>
        <a class="btn btn-outline-secondary" href="<?= e(url('modules/quizzes/index.php')) ?>"><i class="bi bi-arrow-left"></i> Back</a>
    </div>

    <form class="quiz-form" action="#" method="post">
        <div class="g2" style="align-items:start;padding:0;">
            <div class="quiz-stack">
                <div class="card">
                    <div class="form-section-title">Basic Information</div>
                    <div class="form-section-desc">Course mapping and learner-facing details.</div>
                    <div class="row g-3">
                        <div class="col-md-8"><label class="form-label">Quiz Title</label><input class="form-control" value="Full Length Mock Test 01"></div>
                        <div class="col-md-4"><label class="form-label">Quiz Type</label><select class="form-select"><?php foreach ($quizTypes as $item): ?><option><?= e($item) ?></option><?php endforeach; ?></select></div>
                        <div class="col-md-4"><label class="form-label">Course</label><select class="form-select"><?php foreach ($quizCourses as $item): ?><option><?= e($item) ?></option><?php endforeach; ?></select></div>
                        <div class="col-md-4"><label class="form-label">Subject</label><select class="form-select"><?php foreach ($quizSubjects as $item): ?><option><?= e($item) ?></option><?php endforeach; ?></select></div>
                        <div class="col-md-4"><label class="form-label">Chapter / Topic</label><select class="form-select"><option>Time & Distance</option><option>Ratio & Proportion</option><option>Syllogism</option><option>Mixed Topics</option></select></div>
                        <div class="col-md-4"><label class="form-label">Difficulty Level</label><select class="form-select"><option>Easy</option><option>Medium</option><option>Hard</option><option selected>Mixed</option></select></div>
                        <div class="col-md-8"><label class="form-label">Short Description</label><input class="form-control" value="Timed mock test for APC written assessment preparation."></div>
                    </div>
                </div>

                <div class="card">
                    <div class="form-section-title">Quiz Rules</div>
                    <div class="form-section-desc">One source for timing, attempts, passing score, and negative marking.</div>
                    <div class="row g-3">
                        <div class="col-md-3"><label class="form-label">Target Questions</label><input class="form-control" type="number" value="100"></div>
                        <div class="col-md-3"><label class="form-label">Passing Marks</label><input class="form-control" type="number" value="40"></div>
                        <div class="col-md-3"><label class="form-label">Time Limit (minutes)</label><input class="form-control" type="number" value="120"></div>
                        <div class="col-md-3"><label class="form-label">Maximum Attempts</label><input class="form-control" type="number" value="2"></div>
                        <div class="col-md-3"><label class="form-label">Negative Marking</label><select class="form-select"><option selected>Yes</option><option>No</option></select></div>
                        <div class="col-md-3"><label class="form-label">Negative Marks / Wrong</label><input class="form-control" type="number" step="0.25" value="0.25"></div>
                        <div class="col-md-3"><label class="form-label">Question Order</label><select class="form-select"><option>Fixed</option><option>Random</option></select></div>
                        <div class="col-md-3"><label class="form-label">Option Order</label><select class="form-select"><option>Fixed</option><option>Random</option></select></div>
                    </div>
                </div>

                <div class="card">
                    <div class="form-section-title">Feedback & Schedule</div>
                    <div class="form-section-desc">Result visibility, answer review, and publishing window.</div>
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Allow Retake</label><select class="form-select"><option selected>Yes</option><option>No</option></select></div>
                        <div class="col-md-4"><label class="form-label">Show Result Immediately</label><select class="form-select"><option selected>Yes</option><option>No</option></select></div>
                        <div class="col-md-4"><label class="form-label">Show Correct Answer</label><select class="form-select"><option>After Submit</option><option>Never</option><option>After Due Date</option></select></div>
                        <div class="col-md-4"><label class="form-label">Show Explanation</label><select class="form-select"><option selected>Yes</option><option>No</option></select></div>
                        <div class="col-md-4"><label class="form-label">Start Date & Time</label><input class="form-control" type="datetime-local" value="2026-07-06T09:00"></div>
                        <div class="col-md-4"><label class="form-label">End Date & Time</label><input class="form-control" type="datetime-local" value="2026-07-12T23:59"></div>
                        <div class="col-md-4"><label class="form-label">Status</label><select class="form-select"><?php foreach ($quizStatuses as $item): ?><option><?= e($item) ?></option><?php endforeach; ?></select></div>
                    </div>
                </div>
            </div>

            <div class="quiz-stack">
                <div class="card quiz-flow-card">
                    <div class="form-section-title">Quiz Structure</div>
                    <div class="form-section-desc">Question totals are calculated after assigning questions.</div>
                    <div class="quiz-summary-grid">
                        <div><strong><?= count($questions) ?></strong><span>Assigned Questions</span></div>
                        <div><strong><?= e(array_sum(array_column($questions, 'marks'))) ?></strong><span>Total Marks</span></div>
                    </div>
                    <a class="btn btn-outline-secondary w-100 mt-3" href="<?= e(url('modules/quizzes/questions.php')) ?>">Open Question Builder</a>
                </div>
                <div class="card">
                    <div class="form-section-title">Instructions</div>
                    <div class="form-section-desc">Shown before learners begin the test.</div>
                    <textarea id="quiz-instructions" class="form-control" rows="8">Read each question carefully. Use Save & Next to record your answer. You can mark questions for review before final submission.</textarea>
                </div>
                <div class="card instruction-preview">
                    <div class="form-section-title">Default Preview</div>
                    <ul><li>Total duration is 120 minutes.</li><li>Wrong answers deduct 0.25 marks.</li><li>Submit only after reviewing the question palette.</li></ul>
                </div>
                <div class="card quiz-actions-card">
                    <button class="btn btn-outline-secondary" type="button">Save as Draft</button>
                    <a class="btn btn-primary" href="<?= e(url('modules/quizzes/questions.php')) ?>">Save & Add Questions</a>
                    <button class="btn btn-primary" type="button">Publish Quiz</button>
                    <a class="btn btn-outline-secondary" href="<?= e(url('modules/quizzes/index.php')) ?>">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.ClassicEditor) ClassicEditor.create(document.querySelector('#quiz-instructions')).catch(console.error);
});
</script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
