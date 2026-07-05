<?php $exam = $exam ?? ['category_id' => '', 'title' => '', 'description' => '', 'duration_minutes' => 60, 'total_marks' => 100, 'passing_marks' => 40, 'status' => 'draft']; ?>
<div class="panel col-xl-8">
    <form method="post">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Title</label>
                <input class="form-control" name="title" value="<?= e($exam['title']) ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Category</label>
                <select class="form-select" name="category_id">
                    <option value="">No category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= e($category['id']) ?>" <?= (string) $exam['category_id'] === (string) $category['id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4"><?= e($exam['description']) ?></textarea>
            </div>
            <div class="col-md-3"><label class="form-label">Duration</label><input class="form-control" type="number" name="duration_minutes" value="<?= e($exam['duration_minutes']) ?>" min="1" required></div>
            <div class="col-md-3"><label class="form-label">Total Marks</label><input class="form-control" type="number" name="total_marks" value="<?= e($exam['total_marks']) ?>" min="1" required></div>
            <div class="col-md-3"><label class="form-label">Passing Marks</label><input class="form-control" type="number" name="passing_marks" value="<?= e($exam['passing_marks']) ?>" min="1" required></div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status">
                    <?php foreach (['draft', 'published', 'closed'] as $status): ?>
                        <option value="<?= e($status) ?>" <?= $exam['status'] === $status ? 'selected' : '' ?>><?= e(ucfirst($status)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Exam</button>
            <a class="btn btn-outline-secondary" href="<?= e(url('modules/exams/list.php')) ?>">Cancel</a>
        </div>
    </form>
</div>
