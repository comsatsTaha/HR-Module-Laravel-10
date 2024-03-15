<?php

namespace Database\Seeders;

use App\Models\SalaryStructure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalaryStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SalaryStructure::create([
            'bps' => '1',
            'mts' => '13550',
            'rate_of_increment' => '430',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '2',
            'mts' => '13820',
            'rate_of_increment' => '490',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '3',
            'mts' => '14260',
            'rate_of_increment' => '580',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '4',
            'mts' => '14690',
            'rate_of_increment' => '660',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '5',
            'mts' => '15230',
            'rate_of_increment' => '750',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '6',
            'mts' => '15760',
            'rate_of_increment' => '840',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '7',
            'mts' => '16310',
            'rate_of_increment' => '910',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '8',
            'mts' => '16890',
            'rate_of_increment' => '1000',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '9',
            'mts' => '17470',
            'rate_of_increment' => '1090',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '10',
            'mts' => '18050',
            'rate_of_increment' => '1190',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '11',
            'mts' => '18650',
            'rate_of_increment' => '1310',
            'max_stages' => '30',
        ]);

        SalaryStructure::create([
            'bps' => '12',
            'mts' => '19770',
            'rate_of_increment' => '1430',
            'max_stages' => '30',
        ]);
        SalaryStructure::create([
            'bps' => '13',
            'mts' => '21160',
            'rate_of_increment' => '1560',
            'max_stages' => '30',
        ]);

        SalaryStructure::create([
            'bps' => '14',
            'mts' => '22530',
            'rate_of_increment' => '1740',
            'max_stages' => '30',
        ]);

        SalaryStructure::create([
            'bps' => '15',
            'mts' => '23920',
            'rate_of_increment' => '1980',
            'max_stages' => '30',
        ]);

        SalaryStructure::create([
            'bps' => '16',
            'mts' => '28070',
            'rate_of_increment' => '2260',
            'max_stages' => '30',
        ]);
        
        SalaryStructure::create([
            'bps' => '17',
            'mts' => '45070',
            'rate_of_increment' => '3420',
            'max_stages' => '20',
        ]);
        SalaryStructure::create([
            'bps' => '18',
            'mts' => '56880',
            'rate_of_increment' => '4260',
            'max_stages' => '20',
        ]);
        SalaryStructure::create([
            'bps' => '19',
            'mts' => '87840',
            'rate_of_increment' => '4530',
            'max_stages' => '20',
        ]);
        SalaryStructure::create([
            'bps' => '20',
            'mts' => '102470',
            'rate_of_increment' => '6690',
            'max_stages' => '14',
        ]);
        SalaryStructure::create([
            'bps' => '21',
            'mts' => '113790',
            'rate_of_increment' => '7420',
            'max_stages' => '14',
        ]);
        SalaryStructure::create([
            'bps' => '22',
            'mts' => '122190',
            'rate_of_increment' => '8710',
            'max_stages' => '14',
        ]);
       
        
    }
}
