<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Hakan Soytürk',
                'email' => "hakan.syturk@gmail.com",
                'password' => Hash::make('12345'),
                'created_at' => now(),
                "updated_at" => now()
            ]          
        ];

        foreach ($users as $user) {
            User::insert($user);
        }
    }
}
