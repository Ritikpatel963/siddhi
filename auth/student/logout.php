<?php
require_once __DIR__ . '/../../adminpanel/includes/functions.php';
unset($_SESSION['student_id'], $_SESSION['student_name']);
session_regenerate_id(true);
header('Location: ' . site_url('auth/student'));
exit;
