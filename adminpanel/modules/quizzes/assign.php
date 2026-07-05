<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/data.php';
$pageTitle = 'Assign Quiz to Students';
$active = 'quizzes';
include __DIR__ . '/../../includes/header.php';
?>
<div class="quiz-page">
    <div class="quiz-toolbar">
        <div><h2>Assign Quiz to Students</h2><p>Select a quiz and assign it to purchased students or a batch.</p></div>
        <a class="btn btn-outline-secondary" href="<?= e(url('modules/quizzes/index.php')) ?>">Back</a>
    </div>

    <div class="panel mb-3">
        <div class="row g-3 align-items-end">
            <div class="col-lg-6"><label class="form-label">Quiz</label><select class="form-select"><?php foreach ($quizzes as $quiz): ?><option><?= e($quiz['title']) ?></option><?php endforeach; ?></select></div>
            <div class="col-lg-3"><label class="form-label">Assigned Questions</label><input class="form-control" value="<?= count($questions) ?> questions / <?= e(array_sum(array_column($questions, 'marks'))) ?> marks" readonly></div>
            <div class="col-lg-3"><a class="btn btn-outline-secondary w-100" href="<?= e(url('modules/quizzes/questions.php')) ?>">Manage Questions</a></div>
        </div>
    </div>

    <div class="panel mb-3">
        <div class="row g-3 align-items-end">
            <div class="col-md-3"><label class="form-label">Course</label><select class="form-select"><option>All Courses</option><?php foreach ($quizCourses as $item): ?><option><?= e($item) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-2"><label class="form-label">Batch</label><select class="form-select"><option>All Batches</option><option>Morning A</option><option>Evening B</option><option>Weekend</option></select></div>
            <div class="col-md-2"><label class="form-label">Subject</label><select class="form-select"><option>All Subjects</option><?php foreach ($quizSubjects as $item): ?><option><?= e($item) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-3"><label class="form-label">Search Student</label><input class="form-control" placeholder="Name, email, mobile"></div>
            <div class="col-md-2"><label class="form-label">Purchase Status</label><select class="form-select"><option>Purchased</option><option>Pending</option><option>Expired</option></select></div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="panel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle data-table">
                        <thead><tr><th><input type="checkbox" checked></th><th>Student Name</th><th>Email / Mobile</th><th>Course Purchased</th><th>Batch</th><th>Purchase Date</th><th>Quiz Status</th><th>Attempts</th><th>Last Attempt</th><th>Actions</th></tr></thead>
                        <tbody><?php foreach ($students as $student): ?><tr><td><input type="checkbox" checked></td><td><strong><?= e($student['name']) ?></strong></td><td><?= e($student['email']) ?><div class="small text-secondary"><?= e($student['mobile']) ?></div></td><td><?= e($student['course']) ?></td><td><?= e($student['batch']) ?></td><td><?= e($student['purchase']) ?></td><td><?= quiz_badge($student['status']) ?></td><td><?= e($student['attempts']) ?></td><td><?= e($student['last']) ?></td><td><button class="btn btn-sm btn-outline-secondary" type="button">View</button></td></tr><?php endforeach; ?></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="form-section-title">Student Assignment Options</div>
                <div class="form-section-desc">Choose recipients and schedule access.</div>
                <?php foreach (['Assign to all students of selected course', 'Assign to selected students only', 'Assign to batch', 'Send notification'] as $index => $label): ?>
                    <label class="quiz-check"><input type="checkbox" <?= $index === 1 || $index === 3 ? 'checked' : '' ?>> <span><?= e($label) ?></span></label>
                <?php endforeach; ?>
                <div class="row g-3 mt-1">
                    <div class="col-12"><label class="form-label">Schedule Assignment Date</label><input class="form-control" type="datetime-local" value="2026-07-06T09:00"></div>
                    <div class="col-12"><label class="form-label">Due Date</label><input class="form-control" type="datetime-local" value="2026-07-12T23:59"></div>
                </div>
                <div class="quiz-actions-card mt-3">
                    <button class="btn btn-primary" type="button">Assign Quiz</button>
                    <button class="btn btn-outline-danger" type="button">Remove Assignment</button>
                    <button class="btn btn-outline-secondary" type="button">Save Schedule</button>
                    <a class="btn btn-outline-secondary" href="<?= e(url('modules/quizzes/index.php')) ?>">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
