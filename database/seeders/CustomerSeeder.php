<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Türker Jöntürk',
                'revenue' => "0",
                'created_at' => now(),
                "updated_at" => now()
            ],
            [
                'name' => 'Kaptan Devopuz',
                'revenue' => "0",
                'created_at' => now(),
                "updated_at" => now()
            ],
            [
                'name' => 'İsa Sonuyumaz',
                'revenue' => "0",
                'created_at' => now(),
                "updated_at" => now()
            ]   
        ];

        foreach ($customers as $customer) {
            Customer::insert($customer);
        }
    }
}
