<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            ['room_no' => '101', 'capacity' => '20'],
            ['room_no' => '102', 'capacity' => '20'],
            ['room_no' => '103', 'capacity' => '20'],
            ['room_no' => '104', 'capacity' => '20'],
            ['room_no' => '105', 'capacity' => '20'],
        ];

        foreach ($rooms as $room) {
            ClassRoom::create($room);
        }
    }
}
