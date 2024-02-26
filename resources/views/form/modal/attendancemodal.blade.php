<div class="modal custom-modal fade" id="attendance_info{{$key}}{{$innerkey}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Detail -  {{$att['employee']['name']}}</h5>
                {{-- <br>
                <h5 class="modal-title"> 
                    {{$att['employee']['name']}}
                </h5> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card punch-status">
                            <div class="card-body">
                                @php
                                $totalHours = 0;
                            @endphp
                                <h5 class="card-title">Timesheet <small class="text-muted">{{date('d-M-Y',strtotime($innerkey))}}</small></h5>
                                @foreach($attendancebydate as $singleKey=>$singleattendance)
                                @if($singleKey== "check_in")
                                <div class="punch-det">
                                    <h6>Punch In at</h6>
                                    <p style="color: black"> {{date('h:i:s',strtotime($singleattendance))}}</p>
                                </div>
                                @php
                                $checkInTime = strtotime($singleattendance);
                            @endphp
                                @continue
                                @else
                                <div class="punch-det">
                                    <h6>Punch Out at</h6>
                                    <p style="color: black"> {{date('h:i:s',strtotime($singleattendance))}}</p>
                                </div>
                                @php
                                $checkOutTime = strtotime($singleattendance);
                                $hoursWorked = ($checkOutTime - $checkInTime) / 3600; // Convert seconds to hours
                                $totalHours += $hoursWorked;
                            @endphp
                                @continue
                                @endif
                                
                                {{-- <span>{{ $singleKey }} &nbsp; {{$singleattendance}}</span> <br> --}}
                                
                                {{-- <div class="punch-info">
                                    <div class="punch-hours">
                                        <span>3.45 hrs</span>
                                    </div>
                                </div> --}}
                          
                                @endforeach
                                <div class="punch-info">
                                    <div class="punch-hours">
                                        <span>{{ number_format($totalHours, 2) }} hrs</span>
                                    </div>
                                </div>
                                {{-- <div class="statistics">
                                    <div class="row">
                                        <div class="col-md-6 col-6 text-center">
                                            <div class="stats-box">
                                                <p>Break</p>
                                                <h6>1.21 hrs</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 text-center">
                                            <div class="stats-box">
                                                <p>Overtime</p>
                                                <h6>3 hrs</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card recent-activity">
                            <div class="card-body">
                                <h5 class="card-title">Activity</h5>
                                <ul class="res-activity-list">
                                    @foreach($attendancebydate as $singleKey=>$singleattendance)
                                    @if($singleKey== "check_in")
                                    <li>
                                        <p class="mb-0">Check In at</p>
                                        <p class="res-activity-time" style="color: black">
                                            <i class="fa fa-clock-o"></i>
                                            {{$singleattendance}}
                                        </p>
                                    </li>
                                    @else
                                    <li>
                                        <p class="mb-0">CheckOut At</p>
                                        <p class="res-activity-time" style="color: black">
                                            <i class="fa fa-clock-o"></i>
                                            {{$singleattendance}}
                                        </p>
                                    </li>
                                    @endif
                                    @endforeach
                                    @if($totalHours > 8)
                                    @php
                                        $overtimeHours = $totalHours - 8;
                                    @endphp
                                    <li>
                                        <p class="mb-0">Overtime</p>
                                        <p class="res-activity-time" style="color: black">
                                            <i class="fa fa-clock-o"></i>
                                            {{ number_format($overtimeHours, 2) }} hrs
                                        </p>
                                    </li>
                                    @endif
                                </ul>
                                
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>