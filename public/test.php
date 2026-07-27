<?php
header('Content-Type: text/plain');
http_response_code(200);
echo 'POST OK: ' . ($_POST['email'] ?? 'no-email') . ' | Time: ' . date('H:i:s');
