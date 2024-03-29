
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                @if(auth()->user()->role_name == "Super Admin")

                <li class="{{set_active(['home','em/dashboard'])}} submenu" >
                    <a href="#" class="{{ set_active(['home','em/dashboard']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard blackcolour" ></i>
                        <span class="blackcolour"> Dashboard</span> <span class="menu-arrow blackcolour"></span>
                    </a>    
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li ><a class="{{set_active(['home'])}} " href="{{ route('home') }}" style="color: black">Admin Dashboard</a></li>
                        <li><a class="{{set_active(['em/dashboard'])}}" href="{{ route('em/dashboard') }}" style="color: black">Employee Dashboard</a></li>
                    </ul>
                </li>
                @else
                <li class="{{set_active(['home','em/dashboard'])}} submenu" >
                    <a href="#" class="{{ set_active(['home','em/dashboard']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard blackcolour" ></i>
                        <span class="blackcolour"> Dashboard</span> <span class="menu-arrow blackcolour"></span>
                    </a>    
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['em/dashboard'])}}" href="{{ route('em/dashboard') }}" style="color: black">Employee Dashboard</a></li>
                    </ul>
                </li>
                @endif
                
                @if(auth()->user()->role_name == "Super Admin" || auth()->user()->role_name == "Admin")
                    <li class="menu-title"> <span class="blackcolour">Authentication</span> </li>
                    <li class="{{set_active(['search/user/list','userManagement','activity/log','activity/login/logout'])}} submenu">
                        <a href="#" class="{{ set_active(['search/user/list','userManagement','activity/log','activity/login/logout']) ? 'noti-dot' : '' }}">
                            <i class="la la-user-secret blackcolour"></i> <span class="blackcolour"> User Controller</span> <span class="menu-arrow blackcolour"></span>
                        </a>
                        <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                            <li><a class="{{set_active(['search/user/list','userManagement'])}} " href="{{ route('userManagement') }}" style="color: black">All User</a></li>
                            {{-- <li><a class="{{set_active(['activity/log'])}}" href="{{ route('activity/log') }}">Activity Log</a></li> --}}
                            {{-- <li><a class="{{set_active(['activity/login/logout'])}}" href="{{ route('activity/login/logout') }}">Activity User</a></li> --}}
                        </ul>
                 </li>
                 @endif

                @if(auth()->user()->role_name == "Super Admin" || auth()->user()->role_name == "Admin")
                <li class="menu-title"> <span class="blackcolour">Employees</span> </li>
                <li class="{{set_active(['all/employee/list','all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
                    'form/leavesemployee/new','form/leavesettings/page','attendance/page',
                    'attendance/employee/page','form/departments/page','form/designations/page',
                    'form/timesheet/page','form/shiftscheduling/page','form/overtime/page'])}} submenu">
                    <a href="#" class="{{ set_active(['all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
                    'form/leavesemployee/new','form/leavesettings/page','attendance/page',
                    'attendance/employee/page','form/departments/page','form/designations/page',
                    'form/timesheet/page','form/shiftscheduling/page','form/overtime/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-user blackcolour"></i> <span class="blackcolour"> Employees</span> <span class="menu-arrow blackcolour"></span>
                    </a>
                    @php
                    $countLeaves = DB::table('leaves_admins')->where('status', 'Pending')->count();
                @endphp
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['all/employee/list','all/employee/card'])}}" href="{{ route('all/employee/card') }}" style="color: black">All Employees</a></li>
                        <li><a class="{{set_active(['form/holidays/new'])}}" href="{{ route('form/holidays/new') }}" style="color: black">Holidays</a></li>
                        <li><a class="{{set_active(['form/leaves/new'])}}" href="{{ route('form/leaves/new') }}" style="color: black">Leaves (Admin) 
                            <span class="badge badge-pill bg-primary float-right">{{$countLeaves}}</span></a>
                        </li>
                        {{-- <li><a class="{{set_active(['form/leavesemployee/new'])}}" href="{{route('form/leavesemployee/new')}}" style="color: black">Leaves (Employee)</a></li>  --}}
                        {{-- <li><a class="{{set_active(['form/leavesettings/page'])}}" href="{{ route('form/leavesettings/page') }}">Leave Settings</a></li> --}}
                        <li><a class="{{set_active(['attendance/page'])}}" href="{{ route('attendance/page') }}" style="color: black">Attendance</a></li>
                        {{-- <li><a class="{{set_active(['attendance/employee/page'])}}" href="{{ route('attendance/employee/page') }}">Attendance (Employee)</a></li> --}}
                      <li><a class="{{set_active(['form/departments/page'])}}" href="{{ route('form/departments/page') }}" style="color: black">Departments</a></li>
                        <li><a class="{{set_active(['form/designations/page'])}}" href="{{ route('form/designations/page') }}" style="color: black">Designations</a></li>
                         {{--  <li><a class="{{set_active(['form/timesheet/page'])}}" href="{{ route('form/timesheet/page') }}">Timesheet</a></li>
                        <li><a class="{{set_active(['form/shiftscheduling/page'])}}" href="{{ route('form/shiftscheduling/page') }}">Shift & Schedule</a></li>
                        <li><a class="{{set_active(['form/overtime/page'])}}" href="{{ route('form/overtime/page') }}">Overtime</a></li> --}}
                    </ul>
                </li>
                @endif

                @if(auth()->user()->role_name == "Employee")
                <li class="menu-title"> <span class="blackcolour">Employee</span> </li>
                <li class="{{set_active(['all/employee/list','all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
                    'form/leavesemployee/new','form/leavesettings/page','attendance/page',
                    'attendance/employee/page','form/departments/page','form/designations/page',
                    'form/timesheet/page','form/shiftscheduling/page','form/overtime/page'])}} submenu">
                    <a href="#" class="{{ set_active(['all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
                    'form/leavesemployee/new','form/leavesettings/page','attendance/page',
                    'attendance/employee/page','form/departments/page','form/designations/page',
                    'form/timesheet/page','form/shiftscheduling/page','form/overtime/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-user blackcolour"></i> <span class="blackcolour"> Employees</span> <span class="menu-arrow blackcolour"></span>
                    </a>
                    @php
                    $countLeaves = DB::table('leaves_admins')->where('status', 'Pending')->count();
                @endphp
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        {{-- <li><a class="{{set_active(['all/employee/list','all/employee/card'])}}" href="{{ route('all/employee/card') }}" style="color: black">All Employees</a></li> --}}
                        <li><a class="{{set_active(['form/holidays/new'])}}" href="{{ route('form/holidays/new') }}" style="color: black">Holidays</a></li>
                        {{-- <li><a class="{{set_active(['form/leaves/new'])}}" href="{{ route('form/leaves/new') }}" style="color: black">Leaves (Admin)  --}}
                            <span class="badge badge-pill bg-primary float-right">{{$countLeaves}}</span></a>
                        </li>
                        <li><a class="{{set_active(['form/leavesemployee/new'])}}" href="{{route('form/leavesemployee/new')}}" style="color: black">Leaves (Employee)</a></li> 
                        {{-- <li><a class="{{set_active(['form/leavesettings/page'])}}" href="{{ route('form/leavesettings/page') }}">Leave Settings</a></li> --}}
                        <li><a class="{{set_active(['attendance/page'])}}" href="{{ route('attendance/page') }}" style="color: black">Attendance </a></li>
                        {{-- <li><a class="{{set_active(['attendance/employee/page'])}}" href="{{ route('attendance/employee/page') }}">Attendance (Employee)</a></li> --}}
                      {{-- <li><a class="{{set_active(['form/departments/page'])}}" href="{{ route('form/departments/page') }}" style="color: black">Departments</a></li> --}}
                        {{-- <li><a class="{{set_active(['form/designations/page'])}}" href="{{ route('form/designations/page') }}" style="color: black">Designations</a></li> --}}
                         {{--  <li><a class="{{set_active(['form/timesheet/page'])}}" href="{{ route('form/timesheet/page') }}">Timesheet</a></li>
                        <li><a class="{{set_active(['form/shiftscheduling/page'])}}" href="{{ route('form/shiftscheduling/page') }}">Shift & Schedule</a></li>
                        <li><a class="{{set_active(['form/overtime/page'])}}" href="{{ route('form/overtime/page') }}">Overtime</a></li> --}}
                    </ul>
                </li>
                @endif
                {{-- <li class="menu-title"> <span>HR</span> </li> --}}
                {{-- <li class="{{set_active(['create/estimate/page','form/estimates/page','payments','expenses/page'])}} submenu">
                    <a href="#" class="{{ set_active(['create/estimate/page','form/estimates/page','payments','expenses/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-files-o"></i>
                        <span> Sales </span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['create/estimate/page','form/estimates/page'])}}" href="{{ route('form/estimates/page') }}">Estimates</a></li>
                        <li><a class="{{set_active(['payments'])}}" href="{{ route('payments') }}">Payments</a></li>
                        <li><a class="{{set_active(['expenses/page'])}}" href="{{ route('expenses/page') }}">Expenses</a></li>
                    </ul>
                </li> --}}
                {{-- <li class="{{set_active(['form/salary/page','form/payroll/items'])}} submenu">
                    <a href="#" class="{{ set_active(['form/salary/page','form/payroll/items']) ? 'noti-dot' : '' }}"><i class="la la-money"></i>
                    <span> Payroll </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/salary/page'])}}" href="{{ route('form/salary/page') }}"> Employee Salary </a></li>
                        <li><a href="{{ route('form/salary/page') }}"> Payslip </a></li>
                        <li><a class="{{set_active(['form/payroll/items'])}}" href="{{ route('form/payroll/items') }}"> Payroll Items </a></li>
                    </ul>
                </li> --}}
                {{-- <li class="{{set_active(['form/expense/reports/page','form/invoice/reports/page','form/leave/reports/page','form/daily/reports/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/expense/reports/page','form/invoice/reports/page','form/leave/reports/page','form/daily/reports/page']) ? 'noti-dot' : '' }}"><i class="la la-pie-chart"></i>
                    <span> Reports </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/expense/reports/page'])}}" href="{{ route('form/expense/reports/page') }}"> Expense Report </a></li>
                        <li><a class="{{set_active(['form/invoice/reports/page'])}}" href="{{ route('form/invoice/reports/page') }}"> Invoice Report </a></li>
                        <li><a class="{{set_active([''])}}" href="payments-reports.html"> Payments Report </a></li>
                        <li><a class="{{set_active([''])}}" href="employee-reports.html"> Employee Report </a></li>
                        <li><a class="{{set_active([''])}}" href="payslip-reports.html"> Payslip Report </a></li>
                        <li><a class="{{set_active([''])}}" href="attendance-reports.html"> Attendance Report </a></li>
                        <li><a class="{{set_active(['form/leave/reports/page'])}}" href="{{ route('form/leave/reports/page') }}"> Leave Report </a></li>
                        <li><a class="{{set_active(['form/daily/reports/page'])}}" href="{{ route('form/daily/reports/page') }}"> Daily Report </a></li>
                    </ul>
                </li> --}}
                {{-- <li class="menu-title"> <span>Performance</span> </li> --}}
                {{-- <li class="{{set_active(['form/performance/indicator/page','form/performance/page','form/performance/appraisal/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/performance/indicator/page','form/performance/page','form/performance/appraisal/page']) ? 'noti-dot' : '' }}"><i class="la la-graduation-cap"></i>
                    <span> Performance </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/performance/indicator/page'])}}" href="{{ route('form/performance/indicator/page') }}"> Performance Indicator </a></li>
                        <li><a class="{{set_active(['form/performance/page'])}}" href="{{ route('form/performance/page') }}"> Performance Review </a></li>
                        <li><a class="{{set_active(['form/performance/appraisal/page'])}}" href="{{ route('form/performance/appraisal/page') }}"> Performance Appraisal </a></li>
                    </ul>
                </li> --}}
                {{-- <li class="{{set_active(['form/training/list/page','form/trainers/list/page'])}} submenu"> 
                    <a href="#" class="{{ set_active(['form/training/list/page','form/trainers/list/page']) ? 'noti-dot' : '' }}"><i class="la la-edit"></i>
                    <span> Training </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/training/list/page'])}}" href="{{ route('form/training/list/page') }}"> Training List </a></li>
                        <li><a class="{{set_active(['form/trainers/list/page'])}}" href="{{ route('form/trainers/list/page') }}"> Trainers</a></li>
                        <li><a class="{{set_active(['form/training/type/list/page'])}}" href="{{ route('form/training/type/list/page') }}"> Training Type </a></li>
                    </ul>
                </li> --}}
                {{-- <li class="menu-title"> <span>Administration</span> </li>
                <li> <a href="assets.html"><i class="la la-object-ungroup">
                    </i> <span>Assets</span></a>
                </li> --}}
                {{-- <li class="{{set_active(['user/dashboard/index','jobs/dashboard/index','user/dashboard/all','user/dashboard/applied/jobs','user/dashboard/interviewing','user/dashboard/offered/jobs','user/dashboard/visited/jobs','user/dashboard/archived/jobs','user/dashboard/save','jobs','job/applicants','job/details','page/manage/resumes','page/shortlist/candidates','page/interview/questions','page/offer/approvals','page/experience/level','page/candidates','page/schedule/timing','page/aptitude/result'])}} submenu">
                    <a href="#" class="{{ set_active(['user/dashboard/index','jobs/dashboard/index','user/dashboard/all','user/dashboard/save','jobs','job/applicants','job/details']) ? 'noti-dot' : '' }}"><i class="la la-briefcase blackcolour"></i>
                        <span class="blackcolour"> Jobs </span> <span class="menu-arrow blackcolour"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }} {{ (request()->is('job/applicants/*')) ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['user/dashboard/index','user/dashboard/all','user/dashboard/applied/jobs','user/dashboard/interviewing','user/dashboard/offered/jobs','user/dashboard/visited/jobs','user/dashboard/archived/jobs','user/dashboard/save'])}}" href="{{ route('user/dashboard/index') }}" style="color: black"> User Dasboard </a></li>
                        <li><a class="{{set_active(['jobs/dashboard/index'])}}" href="{{ route('jobs/dashboard/index') }}" style="color: black"> Jobs Dasboard </a></li>
                        <li><a class="{{set_active(['jobs','job/applicants','job/details'])}} {{ (request()->is('job/applicants/*')) ? 'active' : '' }}" href="{{ route('jobs') }} " style="color: black"> Manage Jobs </a></li>
                        <li><a class="{{set_active(['page/manage/resumes'])}}" href="{{ route('page/manage/resumes') }}" style="color: black"> Manage Resumes </a></li>
                        <li><a class="{{set_active(['page/shortlist/candidates'])}}" href="{{ route('page/shortlist/candidates') }}" style="color: black"> Shortlist Candidates </a></li>
                        <li><a class="{{set_active(['page/interview/questions'])}}" href="{{ route('page/interview/questions') }}" style="color: black"> Interview Questions </a></li>
                        <li><a class="{{set_active(['page/offer/approvals'])}}" href="{{ route('page/offer/approvals') }}" style="color: black"> Offer Approvals </a></li>
                        <li><a class="{{set_active(['page/experience/level'])}}" href="{{ route('page/experience/level') }}" style="color: black"> Experience Level </a></li>
                        <li><a class="{{set_active(['page/candidates'])}}" href="{{ route('page/candidates') }}" style="color: black"> Candidates List </a></li>
                        <li><a class="{{set_active(['page/schedule/timing'])}}" href="{{ route('page/schedule/timing') }}" style="color: black"> Schedule timing </a></li>
                        <li><a class="{{set_active(['page/aptitude/result'])}}" href="{{ route('page/aptitude/result') }}" style="color: black"> Aptitude Results </a></li>
                    </ul>
                </li> --}}
                {{-- <li class="menu-title"> <span>Pages</span> </li>
                <li class="{{set_active(['employee/profile/*'])}} submenu">
                    <a href="#"><i class="la la-user"></i>
                        <span> Profile </span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: none;">
                        <li><a class="{{set_active(['employee/profile/*'])}}" href="{{ route('all/employee/list') }}"> Employee Profile </a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->