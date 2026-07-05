<?php $pageTitle = 'Resources';
$active = 'resources';
include __DIR__ . '/includes/header.php'; ?>
<div class="page-head">
    <div>
        <h2>Resources</h2>
        <p>Notes, PDFs, videos, and practice files for your enrolled courses.</p>
    </div><input class="search-box" placeholder="Search resources">
</div>
<div class="panel">
    <table class="student-table">
        <thead>
            <tr>
                <th>Resource</th>
                <th>Course</th>
                <th>Type</th>
                <th>Size</th>
                <th>Added</th>
                <th></th>
            </tr>
        </thead>
        <tbody><?php foreach ($resources as $item): ?><tr>
                    <td><strong><?= e($item['title']) ?></strong></td>
                    <td><?= e($item['course']) ?></td>
                    <td><span class="badge muted"><?= e($item['type']) ?></span></td>
                    <td><?= e($item['size']) ?></td>
                    <td><?= e($item['date']) ?></td>
                    <td><button class="btn-secondary" type="button">Download</button></td>
                </tr><?php endforeach; ?></tbody>
    </table>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>