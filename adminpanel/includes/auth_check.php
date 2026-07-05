<?php
require_once __DIR__ . '/functions.php';

if (empty($_SESSION['admin_id'])) {
    redirect('auth/login.php');
}
