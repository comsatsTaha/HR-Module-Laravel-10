<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceEmployee;
use App\Models\AttendenceEmployee;
use App\Models\Holiday;
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
        // dd($request->all());
        // $request->validate([
        //     'leave_type'   => 'required|string|max:255',
        //     'from_date'    => 'required|string|max:255',
        //     'to_date'      => 'required|string|max:255',
        //     'leave_reason' => 'required|string|max:255',
        // ]);
        $attendanceemployee = auth()->user();
      
        DB::beginTransaction();
        try {

            $from_date = new DateTime($request->from_date);
            $to_date = new DateTime($request->to_date);
            $day     = $from_date->diff($to_date);
            $days    = $day->d;

            $leaves = new LeavesAdmin;
            $leaves->user_id        = $attendanceemployee->user_id;
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
                    $firstCheckIn = null;
                    $lastCheckOut = null;
    
                    foreach ($groupedAttendance as $attendance) {
                        if ($attendance->type == 0 && ($firstCheckIn == null || $attendance->date_time < $firstCheckIn)) {
                            $firstCheckIn = $attendance->date_time;
                        } elseif ($attendance->type == 1 && ($lastCheckOut == null || $attendance->date_time > $lastCheckOut)) {
                            $lastCheckOut = $attendance->date_time;
                        }
                    }
    
                    return [
                        'check_in' => $firstCheckIn,
                        'check_out' => $lastCheckOut,
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
    
    

        $currentMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();


                $dates = [];
        while ($currentMonth <= $lastDayOfMonth) {
            $dates[] = $currentMonth->copy();
            $currentMonth->addDay();
        }

        $datesOnly = [];
        foreach ($dates as $carbonDate) {
            $datesOnly[$carbonDate->toDateString()] = $carbonDate->format('l');
        }
        // dd($datesOnly);

        $holidays= Holiday::all();
        $holidays= $holidays->toArray();

        $userLeaves = LeavesAdmin::where('user_id', auth()->user()->user_id)->get();

     
        $employeesnames= AttendanceEmployee::all()->pluck('name');
        return view('form.attendance', compact('attendance','datesOnly','holidays','employeesnames','userLeaves'));
    }

    // attendance employee
    public function AttendanceEmployee()
    {
        return view('form.attendanceemployee');
    }


    public function searchattendance(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        $name = $request->input('name'); // Assuming name is the parameter name for the name search
    
        // Create a Carbon instance for the provided month and year
        $currentMonth = Carbon::createFromDate($year, $month, 1)->format('Y-m');
        
        $attendanceQuery = AttendanceEmployee::with('attendance');
    
        // If name parameter is provided, filter by name
        if ($name) {
            $attendanceQuery->whereHas('attendance', function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });
        }
    
        $attendance = $attendanceQuery->get()
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
                        $firstCheckIn = null;
                        $lastCheckOut = null;
    
                        foreach ($groupedAttendance as $attendance) {
                            if ($attendance->type == 0 && ($firstCheckIn == null || $attendance->date_time < $firstCheckIn)) {
                                $firstCheckIn = $attendance->date_time;
                            } elseif ($attendance->type == 1 && ($lastCheckOut == null || $attendance->date_time > $lastCheckOut)) {
                                $lastCheckOut = $attendance->date_time;
                            }
                        }
    
                        return [
                            'check_in' => $firstCheckIn,
                            'check_out' => $lastCheckOut,
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
    
        // Prepare the dates for the view
        $currentMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $lastDayOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
    
        $dates = [];
        while ($currentMonth <= $lastDayOfMonth) {
            $dates[] = $currentMonth->copy();
            $currentMonth->addDay();
        }
    
        $datesOnly = [];
        foreach ($dates as $carbonDate) {
            $datesOnly[$carbonDate->toDateString()] = $carbonDate->format('l');
        }
    
        // Fetch holidays
        $holidays = Holiday::all()->toArray();
        $employeesnames= AttendanceEmployee::all()->pluck('name');
        
    
        return view('form.attendance', compact('attendance', 'datesOnly', 'holidays','employeesnames'));
    }
    
    
    

    // leaves Employee
    public function leavesEmployee()
    {
        $leaves = DB::table('leaves_admins')
        ->join('users', 'users.user_id', '=', 'leaves_admins.user_id')
        ->select('leaves_admins.*', 'users.position', 'users.name', 'users.avatar')
        ->where('leaves_admins.user_id', auth()->user()->user_id)
        ->get();
    
        return view('form.leaves', compact('leaves'));
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
