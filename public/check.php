<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

var_dump(Schema::getColumnListing('rumah_tangga'));
var_dump(Schema::getColumnListing('komunal'));
var_dump(Schema::getColumnListing('spal'));
var_dump(Schema::getColumnListing('laporan'));
