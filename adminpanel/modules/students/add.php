<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('INSERT INTO students (name, email, phone, password, status) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([trim($_POST['name']), trim($_POST['email']), trim($_POST['phone']), password_hash($_POST['password'], PASSWORD_BCRYPT), $_POST['status']]);
    $studentId = (int) $pdo->lastInsertId();
    $enroll = $pdo->prepare('INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)');
    foreach (array_unique(array_map('intval', $_POST['course_ids'] ?? [])) as $courseId) { if ($courseId > 0) { $enroll->execute([$studentId, $courseId]); } }
    $pdo->commit();
    flash('success', 'Student added.');
    redirect('modules/students/list.php');
}

$pageTitle = 'Add Student';
$active = 'students';
$student = ['name' => '', 'email' => '', 'phone' => '', 'status' => 'active'];
$courses = $pdo->query('SELECT id, name FROM courses WHERE status = \'active\' ORDER BY name')->fetchAll();
$enrolledCourseIds = [];
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/form.php';
include __DIR__ . '/../../includes/footer.php';
