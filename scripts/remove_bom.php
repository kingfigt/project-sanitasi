<?php
$path = __DIR__ . '/../app/Http/Controllers/Api/SanitasiApiController.php';
$data = file_get_contents($path);
// Remove UTF-8 BOM if present
if (substr($data,0,3) === "\xEF\xBB\xBF") {
    file_put_contents($path, substr($data,3));
    echo "BOM removed\n";
} else {
    echo "No BOM found\n";
}
