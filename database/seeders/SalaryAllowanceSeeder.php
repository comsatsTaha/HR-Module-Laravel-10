<?php

namespace Database\Seeders;

use App\Models\Allowance;
use App\Models\SalaryStructure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalaryAllowanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bps = SalaryStructure::all();

        $allowances = Allowance::all();
        
        foreach ($bps as $bpsItem) {
            $bpsItem->allowance()->sync($allowances->pluck('id'));
        }
    }
}
