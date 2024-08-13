<?php

namespace Database\Seeders;

use App\Models\Floor;
use App\Models\Report;
use App\Models\ReportPhoto;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $countReport = 20;

        $users = User::factory()->count(10)->create();

        $floors = Floor::factory()->count(5)->create();

        $report = Report::factory()->count($countReport)->recycle([$users, $floors])->create();

        ReportPhoto::factory()->count(40)->recycle([$report])->create();

        User::create([
            'name' => 'Muhammad Rizky Pratama',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => bcrypt('admin123')
        ]);

    }
}
