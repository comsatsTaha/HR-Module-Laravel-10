<?php

namespace Database\Seeders;

use App\Models\AttendanceEmployee;
use App\Models\AttendenceEmployee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Rats\Zkteco\Lib\ZKTeco;

class AttendanceEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zk = new ZKTeco('192.168.70.32');
        $zk->connect();
        $users = $zk->getUser();
        $user = []; 

        foreach ($users as $userData) { 
            $user[] = [ 
                "id" => $userData['userid'],
                "name" => $userData['name'],
                "role" => $userData["role"],
                "password" => $userData['password'],
                "card_no" => $userData['cardno']
            ];
        }
        
        AttendanceEmployee::insert($user);
    }
}
