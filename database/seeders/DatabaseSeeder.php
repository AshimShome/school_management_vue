<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MasterSeeder;
use Database\Seeders\AdminSettingSeeder;
use Database\Seeders\ExamResultRuleSeeder;
use Database\Seeders\PermissionTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            AdminSettingSeeder::class,
            ExamResultRuleSeeder::class,
            MasterSeeder::class,
        ]);
    }
}
