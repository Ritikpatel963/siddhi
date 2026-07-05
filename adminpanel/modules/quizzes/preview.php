<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/data.php';
$pageTitle = 'Quiz Preview';
$active = 'quizzes';
include __DIR__ . '/../../includes/header.php';
?>
<div class="quiz-preview-shell">
    <div class="preview-topbar">
        <div class="preview-brand"><span class="brand-mark">mE</span><div><strong>Full Length Mock Test 01</strong><small>APC Written Assessment</small></div></div>
        <div class="preview-actions"><button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#instructionsModal">Instructions</button><button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#submitModal">End Test</button></div>
    </div>
    <div class="preview-main">
        <aside class="preview-left">
            <h3>Questions</h3>
            <div class="preview-grid"><?php for ($i = 1; $i <= 30; $i++): ?><button class="preview-q <?= $i === 1 ? 'current' : ($i < 6 ? 'answered' : ($i === 9 ? 'marked' : '')) ?>" type="button"><?= $i ?></button><?php endfor; ?></div>
        </aside>
        <section class="preview-center">
            <div class="preview-question-head"><span>Question 1 of 30</span><button class="btn btn-outline-secondary btn-sm" type="button" id="markReview">Mark for review</button></div>
            <div class="preview-question-body">
                <span class="quiz-badge active">Quantitative Aptitude</span>
                <h3><?= e($questions[0]['q']) ?></h3>
                <div class="preview-options">
                    <?php foreach ($questions[0]['options'] as $index => $option): $letter = chr(65 + $index); ?>
                        <button class="preview-option" type="button"><span><?= e($letter) ?></span><?= e($option) ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="preview-bottom-nav"><button class="btn btn-outline-secondary" type="button">Previous</button><button class="btn btn-outline-secondary" type="button" id="clearResponse">Clear Response</button><button class="btn btn-primary" type="button">Save & Next</button></div>
        </section>
        <aside class="preview-right">
            <div class="preview-card"><span>Timer</span><strong>01:18:42</strong><div class="progress"><div class="progress-bar" style="width:66%"></div></div></div>
            <div class="preview-card"><span>Progress</span><strong>5 / 30</strong><p>Answered questions are saved locally for preview only.</p></div>
            <div class="preview-card"><span>Quick Actions</span><button class="btn btn-outline-secondary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#calculatorModal">Calculator</button><button class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#instructionsModal">Instructions</button></div>
        </aside>
    </div>
    <div class="preview-summary"><span><i class="dot answered"></i>Answered <b>5</b></span><span><i class="dot not-answered"></i>Not Answered <b>4</b></span><span><i class="dot marked"></i>Marked for Review <b>1</b></span><span><i class="dot not-visited"></i>Not Visited <b>20</b></span><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#submitModal">Submit Test</button></div>
</div>

<div class="modal fade" id="submitModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Submit test?</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div><div class="modal-body">You have answered 5 of 30 questions. Submit this preview attempt?</div><div class="modal-footer"><button class="btn btn-outline-secondary" data-bs-dismiss="modal" type="button">Review Again</button><button class="btn btn-danger" type="button">Submit</button></div></div></div></div>
<div class="modal fade" id="calculatorModal" tabindex="-1"><div class="modal-dialog modal-sm modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Calculator</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div><div class="modal-body"><input class="form-control mb-2" value="0"><div class="calc-grid"><?php foreach (['7','8','9','/','4','5','6','*','1','2','3','-','0','.','=','+'] as $key): ?><button class="btn btn-outline-secondary" type="button"><?= e($key) ?></button><?php endforeach; ?></div></div></div></div></div>
<div class="modal fade" id="instructionsModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Instructions</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div><div class="modal-body"><ul><li>Use Save & Next after choosing an answer.</li><li>Marked questions can be submitted or reviewed later.</li><li>Do not refresh during a live test.</li></ul></div></div></div></div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.preview-option').forEach(button => button.addEventListener('click', function () {
        document.querySelectorAll('.preview-option').forEach(item => item.classList.remove('selected'));
        this.classList.add('selected');
    }));
    document.getElementById('clearResponse')?.addEventListener('click', () => document.querySelectorAll('.preview-option').forEach(item => item.classList.remove('selected')));
    document.getElementById('markReview')?.addEventListener('click', () => document.querySelector('.preview-q.current')?.classList.toggle('marked'));
});
</script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
