<?php
$dir = __DIR__ . '/../';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($it as $file) {
    if (!$file->isFile()) continue;
    if (pathinfo($file->getFilename(), PATHINFO_EXTENSION) !== 'php') continue;
    $path = $file->getRealPath();
    $data = file_get_contents($path, false, null, 0, 4);
    if ($data === false) continue;
    $head = unpack('C*', $data);
    $bom = ($head[1] ?? 0) === 0xEF && ($head[2] ?? 0) === 0xBB && ($head[3] ?? 0) === 0xBF;
    if ($bom) {
        echo "BOM: $path\n";
        continue;
    }
    $first = file_get_contents($path, false, null, 0, 20);
    if ($first !== false && preg_match('/^\s+/u', $first)) {
        echo "WHITESPACE: $path\n";
    }
}
