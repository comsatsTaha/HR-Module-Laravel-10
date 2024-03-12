<div class="modal custom-modal fade" id="approve_leave{{$items->id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Leave Approve</h3>
                    <p>Are you sure want to approve for this leave?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a data-dismiss="modal" class="btn btn-primary continue-btn" onclick="statuschange('Approved',{{$items->id}})">Approve</a>
                        </div>
                        <div class="col-6">
                            <a data-dismiss="modal" class="btn btn-primary cancel-btn" onclick="statuschange('Disapproved',{{$items->id}})">Decline</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function statuschange(status, leaveId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ route('changeLeaveStatus') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                status: status,
                leave_id: leaveId 
            },
            success: function(response) {
                console.log(response);
                $('#labelstatus'.response.id).text(response.status);

            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
}

    $(document).ready(function() {
      
        function changeStatus(status) {
         
        }

        // Attach click event handlers using jQuery
        $('.continue-btn').on('click', function() {
            changeStatus('Approved');
        });

        $('.cancel-btn').on('click', function() {
            changeStatus('Declined');
        });
    });
</script>