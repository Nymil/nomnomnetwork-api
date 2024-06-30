<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'johnDoe',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'janeDoe',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'joeSchmoe',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'janeSmith',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'johnSmith',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            $userToCreate = new User();
            $userToCreate->name = $user['name'];
            $userToCreate->password = $user['password'];
            $userToCreate->save();
        }
    }
}
