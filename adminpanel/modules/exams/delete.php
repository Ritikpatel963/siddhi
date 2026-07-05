<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('modules/exams/list.php');
}

verify_csrf();
$stmt = $pdo->prepare('DELETE FROM exams WHERE id = ?');
$stmt->execute([(int) $_POST['id']]);
flash('success', 'Exam deleted.');
redirect('modules/exams/list.php');
