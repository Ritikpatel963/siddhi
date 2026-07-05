<?php
require_once __DIR__ . '/includes/functions.php';

if (!empty($_SESSION['admin_id'])) {
    redirect('modules/dashboard.php');
}

redirect('auth/login.php');
