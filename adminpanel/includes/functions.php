<?php
if (session_status() === PHP_SESSION_NONE) {
    $sessionPath = __DIR__ . '/../../storage/sessions';
    if (!is_dir($sessionPath)) {
        mkdir($sessionPath, 0777, true);
    }
    session_save_path($sessionPath);
    session_start();
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function app_base(): string
{
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    foreach (['/auth/adminpanel/', '/auth/student/', '/adminpanel/', '/frontend/'] as $marker) {
        $pos = strpos($script, $marker);
        if ($pos !== false) {
            return rtrim(substr($script, 0, $pos), '/');
        }
    }
    return rtrim(str_replace('/index.php', '', $script), '/');
}

function url(string $path = ''): string
{
    $path = ltrim($path, '/');

    if ($path === 'auth/login.php') {
        return admin_auth_url();
    }

    if ($path === 'auth/forgot-password.php') {
        return admin_auth_url('forgot-password.php');
    }

    return admin_url($path);
}

function admin_url(string $path = ''): string
{
    $url = app_base() . '/adminpanel';
    return $path === '' ? $url : $url . '/' . ltrim($path, '/');
}

function admin_auth_url(string $path = ''): string
{
    $url = app_base() . '/auth/adminpanel';
    return $path === '' ? $url : $url . '/' . ltrim($path, '/');
}

function site_url(string $path = ''): string
{
    $base = app_base();
    return $path === '' ? ($base ?: '/') : $base . '/' . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(?string $fallbackUrl = null): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        flash('error', 'Security token expired. Please try again.');
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? $fallbackUrl ?? url('modules/dashboard.php')));
        exit;
    }
}

function flash(string $type, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$type] = $message;
        return null;
    }
    $value = $_SESSION['flash'][$type] ?? null;
    unset($_SESSION['flash'][$type]);
    return $value;
}

function format_date(?string $date): string
{
    return $date ? date('d-m-Y', strtotime($date)) : '-';
}

function status_badge(string $status): string
{
    $classes = [
        'draft' => 'secondary',
        'published' => 'success',
        'closed' => 'danger',
        'active' => 'success',
        'inactive' => 'secondary',
        'pass' => 'success',
        'fail' => 'danger',
    ];
    $class = $classes[$status] ?? 'secondary';
    return '<span class="badge text-bg-' . $class . '">' . e(ucwords(str_replace('_', ' ', $status))) . '</span>';
}

function setting(PDO $pdo, string $key, string $default = ''): string
{
    $stmt = $pdo->prepare('SELECT setting_value FROM app_settings WHERE setting_key = ? LIMIT 1');
    $stmt->execute([$key]);
    return $stmt->fetchColumn() ?: $default;
}


function slugify(string $text): string
{
    // Replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Trim
    $text = trim($text, '-');
    // Remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // Lowercase
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}
