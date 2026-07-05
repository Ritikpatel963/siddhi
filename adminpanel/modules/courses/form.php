<div class="wbar mb-3" style="padding: 0 22px 0px;">
    <div><h2><?= e($pageTitle) ?></h2><p>Provide details below to set up your course.</p></div>
</div>

<form method="post" action="">
    <?= csrf_field() ?>
    
    <div class="g2">
        <!-- Left Column: Basic Info -->
        <div class="card" style="align-self: start;">
            <div class="form-section-title">Basic Information</div>
            <div class="form-section-desc">Course title, description and core details.</div>
            
            <div class="mb-3" style="margin-bottom: 16px;">
                <label class="form-label">Course Name <span class="text-danger">*</span></label>
                <input class="form-control" name="name" placeholder="e.g. Advanced Musculoskeletal Physiotherapy" value="<?= e($course['name']) ?>" required>
            </div>
            
            <div class="mb-3" style="margin-bottom: 16px;">
                <label class="form-label">Course Description</label>
                <textarea id="course-desc-editor" class="form-control" name="description" placeholder="Briefly describe what this course covers..." rows="6"><?= e($course['description']) ?></textarea>
                <span class="form-text">A good description helps students understand what they will learn. Use the text editor to format your content.</span>
            </div>
        </div>

        <!-- Right Column: Settings & Actions -->
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div class="card">
                <div class="form-section-title">Publishing Settings</div>
                <div class="form-section-desc">Control visibility and access.</div>
                
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="active" <?= $course['status'] === 'active' ? 'selected' : '' ?>>🟢 Active (Published)</option>
                        <option value="inactive" <?= $course['status'] === 'inactive' ? 'selected' : '' ?>>⚪ Inactive (Draft)</option>
                    </select>
                </div>
            </div>
            
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
