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
        $user = User::create([
            'firstname' => 'Erlang',
            'lastname' => 'Andriyanputra',
            'email' => 'erlang@republikode.com',
            'password' => Hash::make('erlang'),
            'role' => 'lead'
        ]);
    }
}
