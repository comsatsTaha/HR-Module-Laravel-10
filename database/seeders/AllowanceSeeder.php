<?php

namespace Database\Seeders;

use App\Models\Allowance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AllowanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Allowance::create([
            'name'=>'Mobile Balance',
            'price'=>'1000'
        ]);

        Allowance::create([
            'name'=>'Medical',
            'price'=>'5000'
        ]);
    }
}
