<?php
require_once __DIR__ . '/../../includes/auth_check.php';

$pageTitle = 'Add Course';
$active = 'courses';

// Default values for the form
$course = [
    'name' => '', 'code' => '', 'category_id' => '', 'duration' => '', 'duration_type' => 'Weeks',
    'level' => 'Beginner', 'language' => 'English', 'short_description' => '', 'description' => '', 
    'status' => 'active', 'fees' => '', 'discount_fees' => '', 'tagline' => '', 
    'display_order' => '0', 'meta_title' => '', 'meta_description' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    
    // Assign post values back to form to keep user input
    foreach ($course as $key => $val) {
        if (isset($_POST[$key])) $course[$key] = $_POST[$key];
    }
    
    $name = trim($_POST['name']);
    $code = trim($_POST['code']);
    
    $errors = [];
    if (empty($name)) $errors[] = "Course name is required.";
    if (empty($code)) $errors[] = "Course code is required.";
    
    // Handle File Upload (Optional: You can remove this too if you don't want file saving)
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['thumbnail'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($ext, $allowed)) {
            $errors[] = "Only JPG, JPEG, PNG, and WEBP images are allowed for the thumbnail.";
        } elseif ($file['size'] > 2 * 1024 * 1024) { // 2MB
            $errors[] = "Thumbnail size cannot exceed 2MB.";
        }
    }
    
    if (empty($errors)) {
        // [DATABASE INSERT LOGIC WOULD GO HERE]
        
        flash('success', 'Frontend form submitted successfully! (No DB connection)');
        // redirect('modules/courses/list.php'); // Uncomment to redirect after submit
    } else {
        flash('error', implode("<br>", $errors));
    }
}

// Mock categories for the frontend dropdown
$categories = [
    ['id' => 1, 'name' => 'General Knowledge'],
    ['id' => 2, 'name' => 'Mathematics'],
    ['id' => 3, 'name' => 'Computer Science']
];

include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/form.php';
include __DIR__ . '/../../includes/footer.php';

