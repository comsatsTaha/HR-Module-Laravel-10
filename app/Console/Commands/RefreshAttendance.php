<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\AttendanceEmployee;
use Illuminate\Console\Command;
use Rats\Zkteco\Lib\ZKTeco;

class RefreshAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Attendance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $employeeattendance= Attendance::orderBy('id','desc')->first();
        $zk = new ZKTeco('192.168.70.32');
        $zk->connect();
        $attendanceData = $zk->getAttendance();
        
        $filteredAttendance = [];
        
        foreach ($attendanceData as $attendances) {
            if ($attendances['uid'] > $employeeattendance->id) {
                $filteredAttendance[] = $attendances;
            }
        }
        // dd($filteredAttendance);
        $attendancetocreate= [];
        foreach ($filteredAttendance as $userData) { 
            $attendancetocreate[] = [ 
                "id"=>$userData["uid"],
                "attendance_employee_id" => $userData['id'],
                "state" => $userData['state'],
                "date_time" => $userData["timestamp"],
                "type" => $userData['type'],
            ];
        }
        if($filteredAttendance != [])
             Attendance::insert($attendancetocreate);


    }
}
