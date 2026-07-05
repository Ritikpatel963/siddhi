<div class="wbar mb-3" style="padding: 0 22px 0px;">
    <div><h2><?= e($pageTitle) ?></h2><p>Provide details below to set up your course.</p></div>
</div>

<form method="post" action="" enctype="multipart/form-data">
    <?= csrf_field() ?>
    
    <div class="g2" style="align-items: start;">
        <!-- Left Column: Main Content -->
        <div style="display: flex; flex-direction: column; gap: 16px;">
            
            <!-- Basic Information -->
            <div class="card">
                <div class="form-section-title">Basic Information</div>
                <div class="form-section-desc">Course title, code, and descriptions.</div>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Course Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="name" placeholder="e.g. Advanced PHP Development" value="<?= e($course['name']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Course Code <span class="text-danger">*</span></label>
                        <input class="form-control" name="code" placeholder="e.g. PHP-101" value="<?= e($course['code']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Course Tagline</label>
                    <input class="form-control" name="tagline" placeholder="A catchy one-liner..." value="<?= e($course['tagline']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea class="form-control" name="short_description" rows="2" placeholder="Brief summary for course cards..."><?= e($course['short_description']) ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Full Description</label>
                    <textarea id="course-desc-editor" class="form-control" name="description" placeholder="Comprehensive course details..."><?= e($course['description']) ?></textarea>
                </div>
            </div>

            <!-- Course Details -->
            <div class="card">
                <div class="form-section-title">Course Details</div>
                <div class="form-section-desc">Categorization, duration, and level.</div>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category_id">
                            <option value="">-- Select Category --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $course['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Language</label>
                        <input class="form-control" name="language" placeholder="e.g. English" value="<?= e($course['language']) ?>">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Level</label>
                        <select class="form-select" name="level">
                            <option value="Beginner" <?= $course['level'] === 'Beginner' ? 'selected' : '' ?>>Beginner</option>
                            <option value="Intermediate" <?= $course['level'] === 'Intermediate' ? 'selected' : '' ?>>Intermediate</option>
                            <option value="Advanced" <?= $course['level'] === 'Advanced' ? 'selected' : '' ?>>Advanced</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Duration</label>
                        <input type="number" class="form-control" name="duration" placeholder="e.g. 10" value="<?= e($course['duration']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Duration Type</label>
                        <select class="form-select" name="duration_type">
                            <option value="Days" <?= $course['duration_type'] === 'Days' ? 'selected' : '' ?>>Days</option>
                            <option value="Weeks" <?= $course['duration_type'] === 'Weeks' ? 'selected' : '' ?>>Weeks</option>
                            <option value="Months" <?= $course['duration_type'] === 'Months' ? 'selected' : '' ?>>Months</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="card">
                <div class="form-section-title">SEO Settings</div>
                <div class="form-section-desc">Optimize for search engines.</div>
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input class="form-control" name="meta_title" value="<?= e($course['meta_title']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea class="form-control" name="meta_description" rows="2"><?= e($course['meta_description']) ?></textarea>
                </div>
            </div>

        </div>

        <!-- Right Column: Settings, Media, Actions -->
        <div style="display: flex; flex-direction: column; gap: 16px;">
            
            <!-- Publishing Settings -->
            <div class="card">
                <div class="form-section-title">Publishing Settings</div>
                <div class="form-section-desc">Control visibility.</div>
                
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="active" <?= $course['status'] === 'active' ? 'selected' : '' ?>>🟢 Active (Published)</option>
                        <option value="inactive" <?= $course['status'] === 'inactive' ? 'selected' : '' ?>>⚪ Inactive (Draft)</option>
                        <option value="draft" <?= $course['status'] === 'draft' ? 'selected' : '' ?>>📝 Draft</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" class="form-control" name="display_order" value="<?= e($course['display_order']) ?>">
                    <span class="form-text">Lower numbers appear first.</span>
                </div>
            </div>

            <!-- Pricing -->
            <div class="card">
                <div class="form-section-title">Pricing</div>
                <div class="form-section-desc">Leave empty for free courses.</div>
                <div class="mb-3">
                    <label class="form-label">Course Fees</label>
                    <input type="number" step="0.01" class="form-control" name="fees" placeholder="0.00" value="<?= e($course['fees']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Discount Fees</label>
                    <input type="number" step="0.01" class="form-control" name="discount_fees" placeholder="0.00" value="<?= e($course['discount_fees']) ?>">
                </div>
            </div>

            <!-- Media -->
            <div class="card">
                <div class="form-section-title">Media</div>
                <div class="form-section-desc">Upload course thumbnail.</div>
                
                <div class="mb-3">
                    <label class="form-label">Course Thumbnail</label>
                    <input type="file" class="form-control" name="thumbnail" accept=".jpg,.jpeg,.png,.webp">
                    <span class="form-text">Max size: 2MB. Allowed: JPG, PNG, WEBP.</span>
                </div>
                
                <?php if (!empty($course['thumbnail'])): ?>
                    <div class="mt-2 text-center">
                        <img src="<?= url($course['thumbnail']) ?>" alt="Thumbnail" style="max-width: 100%; border-radius: 8px; border: 1px solid var(--border);">
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Actions -->
            <div class="card" style="background: var(--grey-bg); display: flex; flex-direction: column; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <svg viewBox="0 0 24 24" style="width:16px; height:16px; fill:none; stroke:currentColor; stroke-width:2;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Save Course
                </button>
                <a class="btn btn-outline-secondary" href="<?= e(url('modules/courses/list.php')) ?>" style="width: 100%; text-align:center;">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</form>

<style>
/* Custom CKEditor Styling to match the design system */
.ck-editor__editable_inline {
    min-height: 250px;
    font-family: 'Inter', sans-serif !important;
    font-size: 0.86rem !important;
    color: var(--navy) !important;
}
.ck.ck-editor__main>.ck-editor__editable {
    border-bottom-left-radius: 10px !important;
    border-bottom-right-radius: 10px !important;
    border-color: var(--border) !important;
}
.ck.ck-toolbar {
    border-top-left-radius: 10px !important;
    border-top-right-radius: 10px !important;
    border-color: var(--border) !important;
    background: var(--grey-100) !important;
}
.ck.ck-editor__editable:not(.ck-editor__nested-editable).ck-focused {
    border-color: var(--teal) !important;
    box-shadow: 0 0 0 3px var(--teal-light) !important;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof ClassicEditor !== 'undefined') {
        ClassicEditor
            .create(document.querySelector('#course-desc-editor'), {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
            })
            .catch(error => {
                console.error(error);
            });
    }
});
</script>
