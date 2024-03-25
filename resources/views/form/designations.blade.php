
@extends('layouts.master')
@section('content')
  
    <!-- Page Wrapper -->
    <div class="page-wrapper">
    
        <!-- Page Content -->
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Designations</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Designations</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_designation"><i class="fa fa-plus"></i> Add Designation</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>Designation </th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($designations as $designation)
                                <tr>
                                    <td>{{$designation->id}}</td>
                                    <td>{{$designation->position}}</td>
                                    <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item edit-designation" href="#" data-toggle="modal" data-target="#edit_designation" data-id="{{$designation->id}}" data-position="{{$designation->position}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item delete_designation" href="#" data-toggle="modal" data-id="{{$designation->id}}" data-target="#delete_designation"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Designation Modal -->
        <form action="{{route('form/designations/save')}}" method="POST">
            @csrf
        <div id="add_designation" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Designation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Designation Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="position">
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
        <!-- /Add Designation Modal -->
        
        <!-- Edit Designation Modal -->
        <div id="edit_designation" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Designation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Designation Name <span class="text-danger">*</span></label>
                                <input id="designation_name" class="form-control" type="text" name="position">
                            </div>
                            
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Designation Modal -->
        
        <!-- Delete Designation Modal -->
        <div class="modal custom-modal fade" id="delete_designation" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Designation</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('form/designations/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" id="designation_id" name="id"/> 
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
        <!-- /Delete Designation Modal -->
    
    </div>
    <!-- /Page Wrapper -->

    @section('script')
    
<script>
    // JavaScript to populate modal fields when edit button is clicked
    $(document).ready(function(){
        $('.edit-designation').on('click', function(){
            var id = $(this).data('id');
            var position = $(this).data('position');
            $('#designation_name').val(position);
        });
    });
</script>
    

<script>
    // JavaScript to populate modal fields when edit button is clicked
    $(document).ready(function(){
        $('.delete_designation').on('click', function(){
            // alert();
            var id = $(this).data('id');
            $('#designation_id').val(id);
        });
    });
</script>


    @endsection
@endsection
