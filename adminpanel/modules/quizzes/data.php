<?php
$quizCourses = ['APC Written Assessment', 'Banking Foundation', 'Railway NTPC'];
$quizSubjects = ['Quantitative Aptitude', 'Reasoning Ability', 'English Language', 'General Awareness'];
$quizStatuses = ['Draft', 'Active', 'Scheduled', 'Completed', 'Disabled'];
$quizTypes = ['Practice Quiz', 'Mock Test', 'Chapter Test', 'Final Test'];

$quizzes = [
    ['id' => 1, 'title' => 'Full Length Mock Test 01', 'course' => 'APC Written Assessment', 'subject' => 'Quantitative Aptitude', 'questions' => 100, 'marks' => 100, 'time' => '120 min', 'assigned' => 184, 'status' => 'Active', 'type' => 'Mock Test', 'created' => '05 Jul 2026'],
    ['id' => 2, 'title' => 'Ratio & Proportion Chapter Test', 'course' => 'Banking Foundation', 'subject' => 'Quantitative Aptitude', 'questions' => 25, 'marks' => 50, 'time' => '35 min', 'assigned' => 76, 'status' => 'Scheduled', 'type' => 'Chapter Test', 'created' => '03 Jul 2026'],
    ['id' => 3, 'title' => 'Reasoning Speed Drill', 'course' => 'Railway NTPC', 'subject' => 'Reasoning Ability', 'questions' => 40, 'marks' => 40, 'time' => '30 min', 'assigned' => 112, 'status' => 'Draft', 'type' => 'Practice Quiz', 'created' => '01 Jul 2026'],
    ['id' => 4, 'title' => 'Final Revision Test', 'course' => 'APC Written Assessment', 'subject' => 'General Awareness', 'questions' => 60, 'marks' => 120, 'time' => '75 min', 'assigned' => 148, 'status' => 'Completed', 'type' => 'Final Test', 'created' => '28 Jun 2026'],
];

$students = [
    ['name' => 'Aarav Sharma', 'email' => 'aarav@example.com', 'mobile' => '+91 98765 44120', 'course' => 'APC Written Assessment', 'batch' => 'Morning A', 'purchase' => '20 Jun 2026', 'status' => 'Assigned', 'attempts' => '1/2', 'last' => '04 Jul 2026'],
    ['name' => 'Meera Iyer', 'email' => 'meera@example.com', 'mobile' => '+91 98765 77110', 'course' => 'APC Written Assessment', 'batch' => 'Evening B', 'purchase' => '18 Jun 2026', 'status' => 'Not Assigned', 'attempts' => '0/2', 'last' => '-'],
    ['name' => 'Kabir Khan', 'email' => 'kabir@example.com', 'mobile' => '+91 98765 88990', 'course' => 'Banking Foundation', 'batch' => 'Weekend', 'purchase' => '12 Jun 2026', 'status' => 'Completed', 'attempts' => '2/2', 'last' => '02 Jul 2026'],
    ['name' => 'Nisha Verma', 'email' => 'nisha@example.com', 'mobile' => '+91 98765 22881', 'course' => 'Railway NTPC', 'batch' => 'Morning A', 'purchase' => '09 Jun 2026', 'status' => 'Assigned', 'attempts' => '0/2', 'last' => '-'],
];

$questions = [
    ['q' => 'A train crosses a 240m platform in 36 seconds and a pole in 20 seconds. What is the speed of the train?', 'topic' => 'Time & Distance', 'answer' => 'B', 'marks' => 2, 'difficulty' => 'Medium', 'options' => ['36 km/h', '54 km/h', '72 km/h', '90 km/h']],
    ['q' => 'If the average of five consecutive odd numbers is 37, find the largest number.', 'topic' => 'Average', 'answer' => 'D', 'marks' => 2, 'difficulty' => 'Easy', 'options' => ['37', '39', '41', '45']],
    ['q' => 'The ratio of income to expenditure is 7:5. If savings are Rs. 6,000, what is the income?', 'topic' => 'Ratio', 'answer' => 'C', 'marks' => 2, 'difficulty' => 'Medium', 'options' => ['15,000', '18,000', '21,000', '24,000']],
    ['q' => 'A statement followed by conclusions is given. Choose the conclusion that logically follows.', 'topic' => 'Syllogism', 'answer' => 'A', 'marks' => 1, 'difficulty' => 'Hard', 'options' => ['Only I follows', 'Only II follows', 'Both follow', 'Neither follows']],
];

$attempts = [
    ['student' => 'Aarav Sharma', 'course' => 'APC Written Assessment', 'quiz' => 'Full Length Mock Test 01', 'score' => '82/100', 'percent' => '82%', 'status' => 'Passed', 'time' => '1h 48m', 'date' => '04 Jul 2026'],
    ['student' => 'Kabir Khan', 'course' => 'Banking Foundation', 'quiz' => 'Ratio & Proportion Chapter Test', 'score' => '31/50', 'percent' => '62%', 'status' => 'Passed', 'time' => '29m', 'date' => '02 Jul 2026'],
    ['student' => 'Riya Das', 'course' => 'Railway NTPC', 'quiz' => 'Reasoning Speed Drill', 'score' => '18/40', 'percent' => '45%', 'status' => 'Failed', 'time' => '30m', 'date' => '01 Jul 2026'],
];

function quiz_badge(string $status): string
{
    $key = strtolower(str_replace(' ', '-', $status));
    return '<span class="quiz-badge ' . e($key) . '">' . e($status) . '</span>';
}
