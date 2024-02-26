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

        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>-</option>
                        <option>Jan</option>
                        <option>Feb</option>
                        <option>Mar</option>
                        <option>Apr</option>
                        <option>May</option>
                        <option>Jun</option>
                        <option>Jul</option>
                        <option>Aug</option>
                        <option>Sep</option>
                        <option>Oct</option>
                        <option>Nov</option>
                        <option>Dec</option>
                    </select>
                    <label class="focus-label">Select Month</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>-</option>
                        <option>2019</option>
                        <option>2018</option>
                        <option>2017</option>
                        <option>2016</option>
                        <option>2015</option>
                    </select>
                    <label class="focus-label">Select Year</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
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
