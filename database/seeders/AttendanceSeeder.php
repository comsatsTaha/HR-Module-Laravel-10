<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Attendence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Rats\Zkteco\Lib\ZKTeco;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zk = new ZKTeco('192.168.70.32');
        $zk->connect();
        $users = $zk->getAttendance();
        $attendence = []; 

        foreach ($users as $userData) { 
            $attendence[] = [ 
                "id"=>$userData["uid"],
                "attendance_employee_id" => $userData['id'],
                "state" => $userData['state'],
                "date_time" => $userData["timestamp"],
                "type" => $userData['type'],
            ];
        }
        Attendance::insert($attendence);
    }
}
