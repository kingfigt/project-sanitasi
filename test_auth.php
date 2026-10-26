<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$credentials = [
    'username' => 'admin_sanitasi',
    'password' => 'admin_sanitasi'
];
$attempt = \Illuminate\Support\Facades\Auth::attempt($credentials);
echo "Attempt result: " . ($attempt ? "SUCCESS" : "FAIL") . "\n";
$user = \Illuminate\Support\Facades\Auth::user();
echo "User: " . json_encode($user) . "\n";
