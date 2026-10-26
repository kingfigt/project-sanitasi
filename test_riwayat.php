<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$req = Illuminate\Http\Request::create('/api/riwayat', 'GET', ['id_user'=>1]);
$ctrl = app()->make(App\Http\Controllers\Api\SanitasiController::class);
echo $ctrl->getRiwayatPelaporan($req)->getContent();
