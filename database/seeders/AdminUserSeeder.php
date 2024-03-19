<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            
        User::create([
            'name'      => "SuperAdmin",
            'avatar'    => "",
            'email'     => "ahmad@css.net.pk",
            'join_date' => now(),
            'role_name' => "Super Admin",
            'status'    => 'Active',
            'password'  => Hash::make("CSS@321@#!"),
        ]);
    }
}
