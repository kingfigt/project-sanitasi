<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('username', 'petugas1')->first();
if ($user) {
    $user->password = Illuminate\Support\Facades\Hash::make('12345678');
    $user->save();
    echo "Password petugas1 berhasil diubah menjadi 12345678\n";
} else {
    echo "User petugas1 tidak ditemukan!\n";
}
