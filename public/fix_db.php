<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    DB::statement('ALTER TABLE rumah_tangga MODIFY foto_dokumen TEXT');
    echo "rumah_tangga modified\n";
} catch (\Exception $e) { echo $e->getMessage() . "\n"; }

try {
    DB::statement('ALTER TABLE spal MODIFY foto_dokumen TEXT');
    echo "spal modified\n";
} catch (\Exception $e) { echo $e->getMessage() . "\n"; }

try {
    DB::statement('ALTER TABLE laporan MODIFY foto_bukti TEXT');
    echo "laporan modified\n";
} catch (\Exception $e) { echo $e->getMessage() . "\n"; }
