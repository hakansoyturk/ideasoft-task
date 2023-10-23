<?php

namespace Database\Seeders;

use App\Models\DiscountCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discountCategories = [
            [
                'name' => 'BUY_5_GET_1',
                'type' => "free",
                'amount' => -1,
                'created_at' => now(),
                "updated_at" => now()
            ],
            [
                'name' => '10_PERCENT_OVER_1000',
                'type' => "percentage",
                'amount' => 10,
                'created_at' => now(),
                "updated_at" => now()
            ]
        ];

        foreach ($discountCategories as $discountCategory) {
            DiscountCategory::insert($discountCategory);
        }
    }
}
