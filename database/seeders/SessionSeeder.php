<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $session_data = [
            ['name' => '2021', 'note' => '2021 Session Year'],
            ['name' => '2022', 'note' => '2022 Session Year'],
        ];

        foreach ($session_data as $session) {
            Session::create($session);
        }
    }
}
