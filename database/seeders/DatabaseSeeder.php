<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 開発環境でのみ実行
        if (app()->environment('local')) {
        }
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            ContactSeeder::class,
        ]);
    }
}
