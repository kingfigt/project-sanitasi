<?php
$path = __DIR__ . '/../app/Http/Controllers/Api/SanitasiApiController.php';
$fh = fopen($path, 'rb');
$bytes = fread($fh, 4);
fclose($fh);
$arr = [];
for ($i = 0; $i < strlen($bytes); $i++) { $arr[] = ord($bytes[$i]); }
echo implode(',', $arr) . "\n";
