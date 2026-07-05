<div class="panel col-xl-7">
    <form method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input class="form-control" name="name" value="<?= e($course['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="4"><?= e($course['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
                <option value="active" <?= $course['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $course['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <button class="btn btn-primary">Save Course</button>
        <a class="btn btn-outline-secondary" href="<?= e(url('modules/courses/list.php')) ?>">Cancel</a>
    </form>
</div>
