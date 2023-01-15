<?php

namespace Database\Seeders;

use App\Models\Timezone;
use App\Models\AdminSetting;
use Illuminate\Database\Seeder;

class AdminSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'Schooling - School Management System',
            'email' => 'example@mail.com',
            'address' => 'Mohammadpur,  Dhaka-1207, Bangladesh',
            'phone' => '1922296392',
            'logo' => '/images/logo/logo.png',
            'dark_logo' => '/images/logo/blue-logo.png',
            'favicon' => '/images/fav/favicon.png',
        ];

        // Setting create
        AdminSetting::create($data);

        // Timezone create
        foreach (timezone_identifiers_list() as $zone) {
            Timezone::insert(['value' => $zone, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
