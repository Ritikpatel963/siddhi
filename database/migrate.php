<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Run this migration from the command line.');
}

require __DIR__ . '/../config/db.php';
$sql = preg_replace('/^USE\s+[^;]+;/mi', '', file_get_contents(__DIR__ . '/lms_upgrade.sql'));
$statements = array_filter(array_map('trim', explode(';', $sql)));
foreach ($statements as $statement) {
    $pdo->exec($statement);
}
echo "LMS database migration completed.\n";
