<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/data.php';
$pageTitle = 'Quiz Management';
$active = 'quizzes';
include __DIR__ . '/../../includes/header.php';
?>
<div class="quiz-page">
    <div class="quiz-toolbar">
        <div>
            <h2>Quiz Management</h2>
            <p>Manage quiz setup, questions, student assignment, previews, and attempts.</p>
        </div>
        <a class="btn btn-primary" href="<?= e(url('modules/quizzes/form.php')) ?>"><i class="bi bi-plus-lg"></i> Add Quiz</a>
    </div>

    <div class="panel mb-3">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4"><label class="form-label">Search Quiz</label><input class="form-control" placeholder="Search by title, course, subject"></div>
            <div class="col-sm-6 col-lg-2"><label class="form-label">Course</label><select class="form-select"><option>All Courses</option><?php foreach ($quizCourses as $item): ?><option><?= e($item) ?></option><?php endforeach; ?></select></div>
            <div class="col-sm-6 col-lg-2"><label class="form-label">Subject</label><select class="form-select"><option>All Subjects</option><?php foreach ($quizSubjects as $item): ?><option><?= e($item) ?></option><?php endforeach; ?></select></div>
            <div class="col-sm-6 col-lg-2"><label class="form-label">Status</label><select class="form-select"><option>All Status</option><?php foreach ($quizStatuses as $item): ?><option><?= e($item) ?></option><?php endforeach; ?></select></div>
            <div class="col-sm-6 col-lg-2"><label class="form-label">Quiz Type</label><select class="form-select"><option>All Types</option><?php foreach ($quizTypes as $item): ?><option><?= e($item) ?></option><?php endforeach; ?></select></div>
        </div>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table quiz-table">
                <thead><tr><th>Quiz Title</th><th>Course</th><th>Subject</th><th>Total Questions</th><th>Total Marks</th><th>Time Limit</th><th>Assigned Students</th><th>Status</th><th>Created Date</th><th>Actions</th></tr></thead>
                <tbody>
                <?php foreach ($quizzes as $quiz): ?>
                    <tr>
                        <td><strong><?= e($quiz['title']) ?></strong><div class="small text-secondary"><?= e($quiz['type']) ?></div></td>
                        <td><?= e($quiz['course']) ?></td>
                        <td><?= e($quiz['subject']) ?></td>
                        <td><?= e($quiz['questions']) ?></td>
                        <td><?= e($quiz['marks']) ?></td>
                        <td><?= e($quiz['time']) ?></td>
                        <td><?= e($quiz['assigned']) ?></td>
                        <td><?= quiz_badge($quiz['status']) ?></td>
                        <td><?= e($quiz['created']) ?></td>
                        <td class="table-actions quiz-actions">
                            <a class="btn btn-sm btn-primary" href="<?= e(url('modules/quizzes/preview.php')) ?>">Preview</a>
                            <a class="btn btn-sm btn-outline-secondary" href="<?= e(url('modules/quizzes/questions.php')) ?>">Questions</a>
                            <a class="btn btn-sm btn-outline-secondary" href="<?= e(url('modules/quizzes/assign.php')) ?>">Students</a>
                            <div class="dropdown d-inline-flex">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">More</button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?= e(url('modules/quizzes/form.php')) ?>">Edit Quiz</a></li>
                                    <li><a class="dropdown-item" href="<?= e(url('modules/quiz-results/index.php')) ?>">View Results</a></li>
                                    <li><button class="dropdown-item" type="button">Duplicate</button></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><button class="dropdown-item text-danger" type="button">Delete</button></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
