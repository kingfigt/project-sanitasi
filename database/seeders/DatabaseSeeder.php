<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('desa')->insert([
            ['kelurahan' => 'Kelurahan A', 'rw' => 1, 'rt' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kelurahan' => 'Kelurahan B', 'rw' => 1, 'rt' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kelurahan' => 'Kelurahan C', 'rw' => 2, 'rt' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kelurahan' => 'Kelurahan D', 'rw' => 2, 'rt' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
