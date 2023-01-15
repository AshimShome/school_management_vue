<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feeTypes = [
            [
                'name' => 'Tuition Fee',
                'slug' => Str::slug('Tuition Fee'),
            ],
            [
                'name' => 'Exam Fee',
                'slug' => Str::slug('Exam Fee'),
            ],
            [
                'name' => 'Monthly Fee',
                'slug' => Str::slug('Monthly Fee'),
            ],
            [
                'name' => 'Transport Fee',
                'slug' => Str::slug('Transport Fee'),
            ]
        ];

        foreach ($feeTypes as $feeType) {
            \App\Models\FeeType::create($feeType);
        }
    }
}
