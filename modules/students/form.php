<div class="panel col-xl-7">
    <form method="post">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" value="<?= e($student['name']) ?>" required></div>
            <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= e($student['email']) ?>" required></div>
            <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?= e($student['phone']) ?>"></div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select class="form-select" name="status">
                    <option value="active" <?= $student['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $student['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Password <?= isset($student['id']) ? '(leave blank to keep)' : '' ?></label>
                <input class="form-control" type="password" name="password" <?= isset($student['id']) ? '' : 'required' ?>>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Student</button>
            <a class="btn btn-outline-secondary" href="<?= e(url('modules/students/list.php')) ?>">Cancel</a>
        </div>
    </form>
</div>
