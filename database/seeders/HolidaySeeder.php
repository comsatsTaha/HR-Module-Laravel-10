<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'name_holiday' => 'Kashmir Day',
                'date_holiday' =>'2024-02-05',
            ],
            [
                
                'name_holiday' => 'Election 2024',
                'date_holiday' =>'2024-02-08',
            ],
            [
                
                'name_holiday' => 'Election 2024',
                'date_holiday' =>'2024-02-09',
            ],
            [
                'name_holiday' => 'Pakistan Day',
                'date_holiday' =>'2024-03-23',
            ],
            [
                'name_holiday' => 'Labour Day',
                'date_holiday' =>'2024-05-01',
            ],
            [
                'name_holiday' => 'Independance Day',
                'date_holiday' =>'2024-08-14',
            ]
        ];
        $holidays= Holiday::insert($data);
    }
}
