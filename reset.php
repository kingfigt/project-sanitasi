<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$u = App\Models\User::where('username', 'admin_sanitasi')->first();
$u->password = bcrypt('admin_sanitasi');
$u->save();
echo "Password Reset Done";
