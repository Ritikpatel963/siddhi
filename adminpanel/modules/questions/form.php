<div class="panel col-xl-8">
    <form method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Exam</label>
            <select class="form-select" name="exam_id" required>
                <option value="">Select exam</option>
                <?php foreach ($exams as $exam): ?>
                    <option value="<?= e($exam['id']) ?>" <?= (int) $question['exam_id'] === (int) $exam['id'] ? 'selected' : '' ?>><?= e($exam['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Question Text</label>
            <textarea class="form-control" name="question_text" rows="4" required><?= e($question['question_text']) ?></textarea>
        </div>
        <div class="row g-3">
            <?php foreach (['a', 'b', 'c', 'd'] as $letter): ?>
                <div class="col-md-6">
                    <label class="form-label">Option <?= e(strtoupper($letter)) ?></label>
                    <input class="form-control" name="option_<?= e($letter) ?>" value="<?= e($question['option_' . $letter]) ?>" required>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row g-3 mt-1">
            <div class="col-md-6">
                <label class="form-label d-block">Correct Option</label>
                <?php foreach (['A', 'B', 'C', 'D'] as $option): ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="correct_option" value="<?= e($option) ?>" <?= $question['correct_option'] === $option ? 'checked' : '' ?>>
                        <label class="form-check-label"><?= e($option) ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-3">
                <label class="form-label">Marks</label>
                <input class="form-control" type="number" name="marks" min="1" value="<?= e($question['marks']) ?>" required>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Question</button>
            <a class="btn btn-outline-secondary" href="<?= e(url('modules/questions/list.php')) ?>">Cancel</a>
        </div>
    </form>
</div>
