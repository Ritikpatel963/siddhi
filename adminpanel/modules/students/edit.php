<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();
if (!$student) {
    flash('error', 'Student not found.');
    redirect('modules/students/list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $pdo->beginTransaction();
    $params = [trim($_POST['name']), trim($_POST['email']), trim($_POST['phone']), $_POST['status']];
    $sql = 'UPDATE students SET name = ?, email = ?, phone = ?, status = ?';
    if (!empty($_POST['password'])) {
        $sql .= ', password = ?';
        $params[] = password_hash($_POST['password'], PASSWORD_BCRYPT);
    }
    $sql .= ' WHERE id = ?';
    $params[] = $id;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $pdo->prepare('DELETE FROM student_courses WHERE student_id = ?')->execute([$id]);
    $enroll = $pdo->prepare('INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)');
    foreach (array_unique(array_map('intval', $_POST['course_ids'] ?? [])) as $courseId) { if ($courseId > 0) { $enroll->execute([$id, $courseId]); } }
    $pdo->commit();
    flash('success', 'Student updated.');
    redirect('modules/students/list.php');
}

$pageTitle = 'Edit Student';
$active = 'students';
$courses = $pdo->query('SELECT id, name FROM courses WHERE status = \'active\' ORDER BY name')->fetchAll();
$stmt = $pdo->prepare('SELECT course_id FROM student_courses WHERE student_id = ?'); $stmt->execute([$id]); $enrolledCourseIds = array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/form.php';
include __DIR__ . '/../../includes/footer.php';
