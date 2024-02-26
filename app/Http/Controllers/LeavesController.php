<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceEmployee;
use App\Models\AttendenceEmployee;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\LeavesAdmin;
use Carbon\Carbon;
use DB;
use DateTime;
use Rats\Zkteco\Lib\ZKTeco;

class LeavesController extends Controller
{
    // leaves
    public function leaves()
    {
        $leaves = DB::table('leaves_admins')
            ->join('users', 'users.user_id', '=', 'leaves_admins.user_id')
            ->select('leaves_admins.*', 'users.position', 'users.name', 'users.avatar')
            ->get();

        return view('form.leaves', compact('leaves'));
    }
    // save record
    public function saveRecord(Request $request)
    {
        $request->validate([
            'leave_type'   => 'required|string|max:255',
            'from_date'    => 'required|string|max:255',
            'to_date'      => 'required|string|max:255',
            'leave_reason' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $from_date = new DateTime($request->from_date);
            $to_date = new DateTime($request->to_date);
            $day     = $from_date->diff($to_date);
            $days    = $day->d;

            $leaves = new LeavesAdmin;
            $leaves->user_id        = $request->user_id;
            $leaves->leave_type    = $request->leave_type;
            $leaves->from_date     = $request->from_date;
            $leaves->to_date       = $request->to_date;
            $leaves->day           = $days;
            $leaves->leave_reason  = $request->leave_reason;
            $leaves->save();

            DB::commit();
            Toastr::success('Create new Leaves successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Add Leaves fail :)', 'Error');
            return redirect()->back();
        }
    }

    // edit record
    public function editRecordLeave(Request $request)
    {
        DB::beginTransaction();
        try {

            $from_date = new DateTime($request->from_date);
            $to_date = new DateTime($request->to_date);
            $day     = $from_date->diff($to_date);
            $days    = $day->d;

            $update = [
                'id'           => $request->id,
                'leave_type'   => $request->leave_type,
                'from_date'    => $request->from_date,
                'to_date'      => $request->to_date,
                'day'          => $days,
                'leave_reason' => $request->leave_reason,
            ];

            LeavesAdmin::where('id', $request->id)->update($update);
            DB::commit();
            Toastr::success('Updated Leaves successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Update Leaves fail :)', 'Error');
            return redirect()->back();
        }
    }

    // delete record
    public function deleteLeave(Request $request)
    {
        try {

            LeavesAdmin::destroy($request->id);
            Toastr::success('Leaves admin deleted successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {

            DB::rollback();
            Toastr::error('Leaves admin delete fail :)', 'Error');
            return redirect()->back();
        }
    }

    // leaveSettings
    public function leaveSettings()
    {
        return view('form.leavesettings');
    }

    // attendance admin
    public function attendanceIndex()
    {


        // $data= [];
        // $currentYearMonth = date('Y-m');

        // foreach($users as $parent=>$user){
        //     foreach($attendenceData as $attendence){
        //         $attendanceDate = date('Y-m-d', strtotime($attendence['timestamp']));
        //         $attendanceYearMonth = date('Y-m', strtotime($attendence['timestamp']));

        //         // Check if the attendance date is in the current year and month
        //         if ($user['userid'] == $attendence['id'] && $attendanceYearMonth == $currentYearMonth) {
        //             if (!isset($data[$attendanceDate])) {
        //                 $data[$attendanceDate] = [];
        //             }

        //             if ($attendence['type'] == 0) {
        //                 // Check-in time for status 0
        //                 $data[$attendanceDate][$user['name']]['check_in_time'] = $attendence['timestamp'];
        //             } elseif ($attendence['type'] == 1) {
        //                 // Check-out time for status 1
        //                 $data[$attendanceDate][$user['name']]['check_out_time'] = $attendence['timestamp'];
        //             }
        //         }
        //     }
        // }
      
        // $attendance = AttendanceEmployee::with('attendance')
        //     ->get()
        //     ->map(function ($employee) use ($currentMonth) {
        //         $attendance_by_date = $employee->attendance
        //             ->filter(function ($attendance) use ($currentMonth) {
        //                 return Carbon::parse($attendance->date_time)->format('Y-m') === $currentMonth;
        //             })
        //             ->groupBy(function ($attendance) {
        //                 return Carbon::parse($attendance->date_time)->format('Y-m-d');
        //             });

        //         return [
        //             'employee' => $employee,
        //             'attendance_by_date' => $attendance_by_date,
        //         ];
        //     });

        $currentMonth = Carbon::now()->format('Y-m');
        $attendance = AttendanceEmployee::with('attendance')
        ->get()
        ->filter(function ($employee) use ($currentMonth) {
            // Check if the employee has attendance in the current month
            return $employee->attendance->first(function ($attendance) use ($currentMonth) {
                return Carbon::parse($attendance->date_time)->format('Y-m') === $currentMonth;
            }) !== null;
        })
        ->map(function ($employee) use ($currentMonth) {
            // Your existing code to process attendance for each employee
            $attendance_by_date = $employee->attendance
                ->filter(function ($attendance) use ($currentMonth) {
                    return Carbon::parse($attendance->date_time)->format('Y-m') === $currentMonth;
                })
                ->groupBy(function ($attendance) {
                    return Carbon::parse($attendance->date_time)->format('Y-m-d');
                })
                ->map(function ($groupedAttendance) {
                    $checkIn = null;
                    $checkOut = null;
    
                    foreach ($groupedAttendance as $attendance) {
                        if ($attendance->type == 0) {
                            $checkIn = $attendance->date_time;
                        } elseif ($attendance->type == 1) {
                            $checkOut = $attendance->date_time;
                        }
                    }
    
                    return [
                        'check_in' => $checkIn,
                        'check_out' => $checkOut,
                    ];
                });
    
            $uniqueDates = $employee->attendance
                ->filter(function ($attendance) use ($currentMonth) {
                    return Carbon::parse($attendance->date_time)->format('Y-m') === $currentMonth;
                })
                ->pluck('date_time')
                ->map(function ($dateTime) {
                    return Carbon::parse($dateTime)->format('Y-m-d');
                })
                ->unique()
                ->toArray();
    
            return [
                'employee' => $employee,
                'attendance_by_date' => $attendance_by_date,
                'uniqueDates' => $uniqueDates
            ];
        });
    
    // dd($attendance);

        $currentMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();

        $dates = [];
        while ($currentMonth <= $lastDayOfMonth) {
            $dates[] = $currentMonth->copy();
            $currentMonth->addDay();
        }

        $datesOnly = [];
        foreach ($dates as $carbonDate) {
            $datesOnly[] = $carbonDate->toDateString();
        }

     

        return view('form.attendance', compact('attendance','datesOnly'));
    }

    // attendance employee
    public function AttendanceEmployee()
    {
        return view('form.attendanceemployee');
    }

    // leaves Employee
    public function leavesEmployee()
    {
        return view('form.leavesemployee');
    }

    // shiftscheduling
    public function shiftScheduLing()
    {
        return view('form.shiftscheduling');
    }

    // shiftList
    public function shiftList()
    {
        return view('form.shiftlist');
    }
}
