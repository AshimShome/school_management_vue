<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expenseTypes = [
            [
                'name' => 'Academic Support',
                'slug' => Str::slug('Academic Support'),
            ],
            [
                'name' => 'Institutional Support',
                'slug' => Str::slug('Institutional Support'),
            ],
            [
                'name' => 'Student Services',
                'slug' => Str::slug('Student Services'),
            ],
            [
                'name' => 'Transportation',
                'slug' => Str::slug('Transportation'),
            ],
            [
                'name' => 'Electricity & Water Bill',
                'slug' => Str::slug('Electricity & Water Bill'),
            ]
        ];

        foreach ($expenseTypes as $type) {
            \App\Models\ExpenseType::create($type);
        }
    }
}
