<?php
function student_url(string $path = ''): string
{
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/student/index.php')), '/');
    if (substr($base, -9) === '/includes') {
        $base = dirname($base);
    }
    return $base . '/' . ltrim($path, '/');
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$student = ['name' => 'Aarav Sharma', 'plan' => 'APC Written Assessment', 'avatar' => 'AS', 'email' => 'aarav@example.com', 'mobile' => '+91 98765 44120', 'city' => 'Delhi', 'joined' => '20 Jun 2026', 'student_id' => 'STU-1042'];

$courses = [
    ['title' => 'APC Written Assessment', 'subject' => 'Quantitative Aptitude', 'progress' => 68, 'lessons' => 42, 'completed' => 29, 'valid' => '31 Aug 2026', 'status' => 'Active'],
    ['title' => 'Reasoning Foundation', 'subject' => 'Reasoning Ability', 'progress' => 44, 'lessons' => 28, 'completed' => 12, 'valid' => '15 Sep 2026', 'status' => 'Active'],
    ['title' => 'General Awareness Booster', 'subject' => 'General Awareness', 'progress' => 22, 'lessons' => 35, 'completed' => 8, 'valid' => '20 Sep 2026', 'status' => 'Active'],
];

$resources = [
    ['title' => 'Time & Distance Formula Sheet', 'type' => 'PDF', 'course' => 'APC Written Assessment', 'size' => '1.8 MB', 'date' => '05 Jul 2026'],
    ['title' => 'Ratio Practice Workbook', 'type' => 'PDF', 'course' => 'APC Written Assessment', 'size' => '2.4 MB', 'date' => '03 Jul 2026'],
    ['title' => 'Syllogism Video Notes', 'type' => 'Video', 'course' => 'Reasoning Foundation', 'size' => '18 min', 'date' => '01 Jul 2026'],
    ['title' => 'Weekly Current Affairs', 'type' => 'PDF', 'course' => 'General Awareness Booster', 'size' => '3.1 MB', 'date' => '29 Jun 2026'],
];

$quizzes = [
    ['title' => 'Full Length Mock Test 01', 'course' => 'APC Written Assessment', 'subject' => 'Quantitative Aptitude', 'questions' => 30, 'marks' => 60, 'time' => 45, 'status' => 'Available', 'attempts' => '0/2'],
    ['title' => 'Ratio & Proportion Chapter Test', 'course' => 'APC Written Assessment', 'subject' => 'Quantitative Aptitude', 'questions' => 25, 'marks' => 50, 'time' => 35, 'status' => 'Completed', 'attempts' => '1/2'],
    ['title' => 'Reasoning Speed Drill', 'course' => 'Reasoning Foundation', 'subject' => 'Reasoning Ability', 'questions' => 40, 'marks' => 40, 'time' => 30, 'status' => 'Available', 'attempts' => '0/2'],
];

$questions = [
    ['q' => 'A train crosses a 240m platform in 36 seconds and a pole in 20 seconds. What is the speed of the train?', 'options' => ['36 km/h', '54 km/h', '72 km/h', '90 km/h'], 'answer' => 1],
    ['q' => 'If the average of five consecutive odd numbers is 37, find the largest number.', 'options' => ['37', '39', '41', '45'], 'answer' => 2],
    ['q' => 'The ratio of income to expenditure is 7:5. If savings are Rs. 6,000, what is the income?', 'options' => ['15,000', '18,000', '21,000', '24,000'], 'answer' => 2],
];

$results = [
    ['quiz' => 'Ratio & Proportion Chapter Test', 'course' => 'APC Written Assessment', 'score' => '41/50', 'percent' => '82%', 'status' => 'Passed', 'date' => '04 Jul 2026', 'time' => '29m'],
    ['quiz' => 'Daily Reasoning Drill', 'course' => 'Reasoning Foundation', 'score' => '28/40', 'percent' => '70%', 'status' => 'Passed', 'date' => '02 Jul 2026', 'time' => '24m'],
    ['quiz' => 'Current Affairs Mini Test', 'course' => 'General Awareness Booster', 'score' => '14/25', 'percent' => '56%', 'status' => 'Needs Review', 'date' => '29 Jun 2026', 'time' => '18m'],
];
