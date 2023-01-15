<?php

namespace Database\Seeders;

use App\Models\Session;
use App\Models\AdminSetting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $session = Session::orderByDesc('id')->first();

        if ($session) {
            AdminSetting::first()->update(['default_session_id' => $session->id]);
        }
    }
}
