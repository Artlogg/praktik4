<?php
function writeAuthLog(string $login, string $action, string $info = ''): void
{
    $dir = __DIR__ . '/logs';

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $file = $dir . '/auth.log';
    $time = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    $line = $time
        . ' | ip=' . $ip
        . ' | login=' . ($login !== '' ? $login : '-')
        . ' | action=' . $action;

    if ($info !== '') {
        $line .= ' | info=' . $info;
    }

    $line .= PHP_EOL;

    file_put_contents($file, $line, FILE_APPEND);
}