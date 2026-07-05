<?php
require_once __DIR__ . '/../../adminpanel/includes/functions.php';
if (empty($_SESSION['student_id'])) { header('Location: ' . site_url('auth/student')); exit; }
