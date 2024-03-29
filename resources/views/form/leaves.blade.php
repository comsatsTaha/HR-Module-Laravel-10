
@extends('layouts.master')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            @if(auth()->user()->role_name == "Employee")

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Leaves <span id="year"></span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Leaves</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                    </div>
                </div>
            </div>
            @endif
            @if(auth()->user()->role_name == "Employee")

            <!-- Leave Statistics -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Today Leave Requests</h6>
                        <h4>{{$totalleavesCount}} / 12</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Casual Leaves Requests</h6>
                        <h4>{{$casualLeavesCount}} <span>This Year </span></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Medical Leaves Requests</h6>
                        <h4>{{$medicalLeavesCount}} <span>This Year</span></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Pending Requests</h6>
                        <h4>{{$pendingLeavesCount}}</h4>
                    </div>
                </div>
            </div>
            @endif
            <!-- /Leave Statistics -->

            <!-- Search Filter -->

            @if(auth()->user()->role_name == "Super Admin")
            
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <div class="form-group form-focus select-focus">
                        <select class="select floating"> 
                            <option> -- Select -- </option>
                            <option>Casual Leave</option>
                            <option>Medical Leave</option>
                            <option>Loss of Pay</option>
                        </select>
                        <label class="focus-label">Leave Type</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12"> 
                    <div class="form-group form-focus select-focus">
                        <select class="select floating"> 
                            <option> -- Select -- </option>
                            <option> Pending </option>
                            <option> Approved </option>
                            <option> Rejected </option>
                        </select>
                        <label class="focus-label">Leave Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                    <a href="#" class="btn btn-success btn-block"> Search </a>  
                </div>     
            </div>
            @endif
            <!-- /Search Filter -->

			<!-- /Page Header -->
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Leave Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>No of Days</th>
                                    <th>Reason</th>
                                    @if(auth()->user()->role_name == "Super Admin")
                                    <th class="text-center">Status</th>
                                    @endif
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- @dd($leaves) --}}
                                @if(!empty($leaves))
                                    @foreach ($leaves as $items )  
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="{{ url('employee/profile/'.$items->user_id) }}" class="avatar"><img alt="" src="{{ URL::to('/assets/images/'. $items->avatar) }}" alt="{{ $items->name }}"></a>
                                                    <a href="#">{{ $items->name }}<span>{{ $items->position }}</span></a>
                                                </h2>
                                            </td>
                                            <td hidden class="id">{{ $items->id }}</td>
                                            <td class="leave_type">{{$items->leave_type}}</td>
                                            <td hidden class="from_date">{{ $items->from_date }}</td>
                                            <td>{{date('d F, Y',strtotime($items->from_date)) }}</td>
                                            <td hidden class="to_date">{{$items->to_date}}</td>
                                            <td>{{date('d F, Y',strtotime($items->to_date)) }}</td>
                                            <td class="day">{{$items->day}} Day</td>
                                            <td class="leave_reason">{{$items->leave_reason}}</td>
                                            @if(auth()->user()->role_name == "Super Admin")
                                            <td class="text-center">
                                                <div class="dropdown action-label">
                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-dot-circle-o text-purple"></i> 
                                                        <span id="labelstatus{{$items->id}}"> {{$items->status}}</span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-info"></i> Pending</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#approve_leave{{$items->id}}"><i class="fa fa-dot-circle-o text-success"></i> Approved</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#approve_leave{{$items->id}}"><i class="fa fa-dot-circle-o text-danger"></i> Declined</a>
                                                        
                                                    </div>
                                                </div>
                                            </td>
                                            @endif
                                            @include('form.modal.statusmodal')
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item leaveUpdate" data-toggle="modal" data-id="'.$items->id.'" data-target="#edit_leave"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item leaveDelete" href="#" data-toggle="modal" data-target="#delete_approve"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        
       
        <!-- Add Leave Modal -->
        <form action="{{route('form/leaves/save')}}" method="POST">
            @csrf
        <div id="add_leave" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <select class="select" name="leave_type">
                                    <option selected disabled value="">Select Leave Type</option>
                                    <option>Casual Leave</option>
                                    <option>Medical Leave</option>
                                </select>
                            </div>
                          
                            <div class="form-group">
                                <label>Dates <span class="text-danger">*</span></label>
                                {{-- <div class="cal-icon"> --}}
                                    <input class="form-control" type="date"  name="from_date" id="from_date">
                                {{-- </div> --}}
                            </div>

                            <div class="form-group">
                                <label>To <span class="text-danger">*</span></label>
                          
                                    <input class="form-control" type="date" name="to_date" id="to_date">
                          
                            </div>
                            <div class="form-group">
                                <label>Number of days <span class="text-danger">*</span></label>
                                <input class="form-control" id="number_of_days" readonly  type="text" name="day">
                            </div>
                            {{-- <div class="form-group">
                                <label>Remaining Leaves <span class="text-danger">*</span></label>
                                <input class="form-control" readonly value="12" type="text" name="leave_reason">
                            </div> --}}
                            <div class="form-group">
                                <label>Leave Reason <span class="text-danger">*</span></label>
                                <textarea rows="4" name="leave_reason" class="form-control"></textarea>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <!-- /Add Leave Modal -->
				
        <!-- Edit Leave Modal -->
        <div id="edit_leave" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('form/leaves/edit') }}" method="POST">
                            @csrf
                            <input type="hidden" id="e_id" name="id" value="">
                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <select class="select" id="e_leave_type" name="leave_type">
                                    <option selected disabled>Select Leave Type</option>
                                    <option value="Casual Leave 12 Days">Casual Leave 12 Days</option>
                                    <option value="Medical Leave">Medical Leave</option>
                                    <option value="Loss of Pay">Loss of Pay</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                {{-- <div class="cal-icon"> --}}
                                    <input type="date" class="form-control " id="e_from_date" name="from_date" value="">
                                {{-- </div> --}}
                            </div>
                            <div class="form-group">
                                <label>To <span class="text-danger">*</span></label>
                                {{-- <div class="cal-icon"> --}}
                                    <input type="date" class="form-control " id="e_to_date" name="to_date" value="">
                                {{-- </div> --}}
                            </div>
                            <div class="form-group">
                                <label>Number of days <span class="text-danger">*</span></label>
                                <input class="form-control" readonly  type="text"  name="number_of_days"  id="e_number_of_days">
                            </div>
                            <div class="form-group">
                                <label>Leave Reason <span class="text-danger">*</span></label>
                                <textarea rows="4" class="form-control" id="e_leave_reason" name="leave_reason" value=""></textarea>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Leave Modal -->

        <!-- Approve Leave Modal -->
        
        <!-- /Approve Leave Modal -->
        
        <!-- Delete Leave Modal -->
        <div class="modal custom-modal fade" id="delete_approve" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Leave</h3>
                            <p>Are you sure want to delete this leave?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('form/leaves/edit/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Leave Modal -->
    </div>
    <!-- /Page Wrapper -->
    @section('script')
  
    
<script>
  $(document).on('change','#to_date',function()
    {  
       
        const fromDateInput = document.getElementById('from_date');
        const toDateInput = document.getElementById('to_date');
        // const dayInput = document.getElementById('e_number_of_days');

            const fromDate = new Date(fromDateInput.value);
            const toDate = new Date(toDateInput.value);
            const differenceInTime = toDate.getTime() - fromDate.getTime();
            const differenceInDays = differenceInTime / (1000 * 3600 * 24);
            if (differenceInDays >= 0) {
              
                $("#number_of_days").val(differenceInDays.toFixed(0));
            } else {
                dayInput.value = ''; // Reset to empty if invalid date selection
            }
       

    
    });
</script>


<script>
    $(document).on('change','#e_to_date',function()
      {  
         
          const fromDateInput = document.getElementById('e_from_date');
          const toDateInput = document.getElementById('e_to_date');
          // const dayInput = document.getElementById('e_number_of_days');
  
              const fromDate = new Date(fromDateInput.value);
              const toDate = new Date(toDateInput.value);
              const differenceInTime = toDate.getTime() - fromDate.getTime();
              const differenceInDays = differenceInTime / (1000 * 3600 * 24);
              if (differenceInDays >= 0) {
                
                  $("#e_number_of_days").val(differenceInDays.toFixed(0));
              } else {
                  dayInput.value = ''; // Reset to empty if invalid date selection
              }
         
  
      
      });
  </script>
    
    <script>
        document.getElementById("year").innerHTML = new Date().getFullYear();
    </script>
    {{-- update js --}}
    <script>
        $(document).on('click','.leaveUpdate',function()
        {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.id').text());
            $('#e_number_of_days').val(_this.find('.day').text());
            $('#e_from_date').val(_this.find('.from_date').text());  
            $('#e_to_date').val(_this.find('.to_date').text());  
            $('#e_leave_reason').val(_this.find('.leave_reason').text());

            var leave_type = (_this.find(".leave_type").text());
            var _option = '<option selected value="' + leave_type+ '">' + _this.find('.leave_type').text() + '</option>'
            $( _option).appendTo("#e_leave_type");
        });
    </script>
    {{-- delete model --}}
    <script>
        $(document).on('click','.leaveDelete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
        });
    </script>
    @endsection
@endsection
