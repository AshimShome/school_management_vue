<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Bangla','English','Math','Physics','Chemistry','Computer','Social Science'
        ];

        foreach ($departments as $department ) {
            Department::create(['name'=> $department]);
        }
    }
}
