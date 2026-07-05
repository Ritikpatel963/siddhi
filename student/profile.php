<?php $pageTitle = 'Profile'; $active = 'profile'; include __DIR__ . '/includes/header.php'; ?>
<div class="page-head"><div><h2>Profile</h2><p>Student account, contact details, and learning summary.</p></div></div>
<div class="profile-grid">
    <aside class="panel profile-card">
        <span class="profile-avatar"><?= e($student['avatar']) ?></span>
        <h3><?= e($student['name']) ?></h3>
        <p><?= e($student['student_id']) ?></p>
        <span class="badge available">Active Student</span>
        <div class="profile-meta">
            <div><span>Email</span><strong><?= e($student['email']) ?></strong></div>
            <div><span>Mobile</span><strong><?= e($student['mobile']) ?></strong></div>
            <div><span>Joined</span><strong><?= e($student['joined']) ?></strong></div>
        </div>
    </aside>

    <section class="panel profile-form">
        <div class="section-head"><h3>Personal Details</h3><button class="btn-secondary" type="button">Edit Profile</button></div>
        <div class="form-grid">
            <label><span>Full Name</span><input value="<?= e($student['name']) ?>"></label>
            <label><span>Email</span><input value="<?= e($student['email']) ?>"></label>
            <label><span>Mobile</span><input value="<?= e($student['mobile']) ?>"></label>
            <label><span>City</span><input value="<?= e($student['city']) ?>"></label>
            <label><span>Primary Course</span><input value="<?= e($student['plan']) ?>" readonly></label>
            <label><span>Student ID</span><input value="<?= e($student['student_id']) ?>" readonly></label>
        </div>
        <div class="profile-actions"><button class="btn-primary" type="button">Save Changes</button><button class="btn-secondary" type="button">Change Password</button></div>
    </section>
</div>

<div class="stat-grid compact profile-stats">
    <div class="stat-card"><strong><?= count($courses) ?></strong><span>Courses Enrolled</span></div>
    <div class="stat-card"><strong><?= count($quizzes) ?></strong><span>Assigned Quizzes</span></div>
    <div class="stat-card"><strong>74%</strong><span>Average Score</span></div>
</div>

<section class="panel">
    <div class="section-head"><h3>Current Courses</h3><a href="<?= e(student_url('courses.php')) ?>">View all</a></div>
    <table class="student-table"><thead><tr><th>Course</th><th>Subject</th><th>Progress</th><th>Validity</th></tr></thead><tbody><?php foreach ($courses as $course): ?><tr><td><strong><?= e($course['title']) ?></strong></td><td><?= e($course['subject']) ?></td><td><?= e($course['progress']) ?>%</td><td><?= e($course['valid']) ?></td></tr><?php endforeach; ?></tbody></table>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
