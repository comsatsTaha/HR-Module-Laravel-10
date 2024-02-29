@extends('layouts.master')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Attendance</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <form action="{{route('searchattendance')}}" method="GET">
        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <select class="form-control" name="name">
                        <option value="" disabled selected>Select Name</option>
                        @foreach($employeesnames as $name)
                        <option value="{{$name}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" name="month" required>
                        <option value="" disabled selected>-</option>
                        <option value="1">Jan</option>
                        <option value="2">Feb</option>
                        <option value="3">Mar</option>
                        <option value="4">Apr</option>
                        <option value="5">May</option>
                        <option value="6">Jun</option>
                        <option value="7">Jul</option>
                        <option value="8">Aug</option>
                        <option value="9">Sep</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>
                    <label class="focus-label">Select Month</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" name="year" required>
                        <option value="" disabled selected>-</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                    </select>
                    <label class="focus-label">Select Year</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <button type="submit" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
    </form>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                @foreach($datesOnly as $key=> $date)
                                <th>{{$key}}<br>{{$date}}</th>

                                @endforeach

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendance as $key=> $att)

                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a class="avatar avatar-xs" href="profile.html"><img alt=""
                                                    src="{{ URL::to('assets/img/profiles/avatar-09.jpg') }}"></a>
                                            <a href="profile.html">{{$att['employee']['name']}}</a>
                                        </h2>
                                    </td>
                                    @php
                                    $holidayDates = array_column($holidays, 'date_holiday');
                                @endphp
                                    @foreach($datesOnly as $datekey=>$date)
                                        <td>
                                            @foreach($att['attendance_by_date'] as $innerkey=>$attendancebydate)
                            
                                                @if(in_array($datekey, $att['uniqueDates']) && $datekey == $innerkey )
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#attendance_info{{$key}}{{$innerkey}}"><i class="fa fa-check text-success"></i>
                                                    @include('form.modal.attendancemodal')
                                                  
                                                @elseif(!(in_array($datekey, $att['uniqueDates'])))
                                                @if(in_array($datekey, $holidayDates))
                                                @php
                                                    $holidayIndex = array_search($datekey, $holidayDates);
                                                @endphp
                                                <span style="color: orange">{{ $holidays[$holidayIndex]['name_holiday'] }}</span>
                                                @elseif(in_array($datekey, $userLeaves->pluck('from_date')->toArray()))
                                                @foreach($userLeaves as $leave)
                                                        @if($leave->from_date === $datekey && $att['employee']->employee && $leave->user_id == $att['employee']->employee->employee_id)
                                                                <span style="color: red">Leave - {{ $leave->leave_reason }}</span>
                                                          

                                                        @elseif($leave->from_date === $datekey)
                                                            <span><i class="fa fa-close text-danger"></i></span>
                                                        @endif
                                                @endforeach
                                            @else
                                                <span><i class="fa fa-close text-danger"></i></span>
                                            @endif
                                                @break
                                                @endif

                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Attendance Modal -->
    
    <!-- /Attendance Modal -->

</div>
<!-- Page Wrapper -->
@endsection
