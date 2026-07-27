<?php
echo "exec: " . (function_exists('exec') ? 'YES' : 'NO') . "\n";
echo "shell_exec: " . (function_exists('shell_exec') ? 'YES' : 'NO') . "\n";
echo "proc_open: " . (function_exists('proc_open') ? 'YES' : 'NO') . "\n";
echo "popen: " . (function_exists('popen') ? 'YES' : 'NO') . "\n";
echo "disable_functions: " . ini_get('disable_functions') . "\n";

$log = __DIR__ . '/../storage/logs/email-*.log*';
$files = glob($log);
echo "Log files: " . implode(', ', $files) . "\n";
if ($files) {
    foreach ($files as $f) {
        echo "--- $f ---\n";
        echo file_get_contents($f) . "\n";
    }
}
