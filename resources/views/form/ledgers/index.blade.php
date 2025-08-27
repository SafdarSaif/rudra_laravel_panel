@extends('layouts.main')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-xxl-12 bst-seller">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive active-projects style-1 ItemsCheckboxSec shorting ">
                            <div class="tbl-caption">
                                <h4 class="heading mb-0">Student Ledgers</h4>
                            </div>
                            <div class="table-responsive">
                                <table id="example3" class="display table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Student Name</th>
                                            <th>Transaction ID</th>
                                            <th>Total Fee</th>
                                            <th>Received Fee</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ledgers ?? '' as $index => $ledger)
                                        <?php
                                            $ledger_datas = App\Models\Ledger::where('student_id', $ledger->id)->get();
                                        ?>
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                                <strong>{{ $ledger->name }}</strong>
                                                <br>{{ $ledger->phone }}
                                                <br>{{ $ledger->email }}
                                            </td>
                                            <td>
                                                @foreach($ledger_datas as $ledger_data)
                                                {{ $ledger_data->provided_transaction_id }}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $ledger->total_fee }}<br>
                                            </td>
                                            <td>
                                                @foreach($ledger_datas as $ledger_data)
                                                <span class="d-flex justify-content-between align-items-center mb-2">
                                                    {{ $ledger_data->fee_received }} ({{ $ledger_data->created_at }})

                                                    {{-- @if($ledger_data->approval_status == 0)
                                                    <a href="javascript:void(0);"
                                                        class="badge bg-warning text-dark ms-2"
                                                        onclick="showFeeDetails('{{ $ledger_data->id }}')">
                                                        Pending
                                                    </a> --}}
                                                    @if($ledger_data->approval_status == 0)
                                                    @if(Auth::check() && Auth::user()->roles == 'Admin')
                                                    <a href="javascript:void(0);"
                                                        class="badge bg-warning text-dark ms-2"
                                                        onclick="showFeeDetails('{{ $ledger_data->id }}')">
                                                        Pending
                                                    </a>
                                                    @else
                                                    <span class="badge bg-warning text-dark ms-2">Pending</span>
                                                    @endif

                                                    @elseif($ledger_data->approval_status == 1)
                                                    <a href="{!! route('downloadInvoice', ['id'=>$ledger_data->id]) !!}"
                                                        class="btn btn-primary shadow btn-xs sharp ms-2">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    @elseif($ledger_data->approval_status == 2)
                                                    <span class="badge bg-danger ms-2">Rejected</span>
                                                    @endif
                                                </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($ledger_datas as $ledger_data)
                                                {{ $ledger_data->due_ammount }}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);"
                                                    onclick="addReceiveFee('{{ $ledger->student_id }}');"
                                                    class="btn btn-success shadow btn-xs sharp me-1">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                    onclick="sendWelcomeMail('{{ $ledger->student_id }}');"
                                                    class="btn btn-info shadow btn-xs sharp me-1">
                                                    <i class="fas fa-envelope"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Fee Details -->
<div class="modal fade" id="feeDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fee Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="feeDetailsContent">
                <!-- Fee details loaded via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function addReceiveFee(id) {
        if (id) {
            $.ajax({
                url: '/getstudentfee/' + id,
                success: function(data) {
                    $('#add_modal_content').html(data);
                    $('#add_modal').modal('show');
                }
            });
        }
    }

    function showFeeDetails(feeId) {
        $.ajax({
            url: '/get-fee-details/' + feeId,
            success: function (data) {
                $('#feeDetailsContent').html(data);
                $('#feeDetailsModal').modal('show');
            }
        });
    }

    function updateFeeStatus(feeId, status) {
    // ✅ Show loading spinner before AJAX starts
    Swal.fire({
        title: "Processing...",
        text: "Please wait while we update the fee status.",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: '/update-fee-status/' + feeId,
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            status: status
        },
        success: function (res) {
            if (res.success) {
                Swal.fire({
                    title: "Updated!",
                    text: "Fee status updated successfully 🎉",
                    icon: "success"
                }).then(() => {
                    $('#feeDetailsModal').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: "Failed!",
                    text: "Error: " + res.message,
                    icon: "error"
                });
            }
        },
        error: function () {
            Swal.fire({
                title: "Oops...",
                text: "Something went wrong while updating fee status.",
                icon: "error"
            });
        }
    });
}


  function sendWelcomeMail(studentId) {
    Swal.fire({
        title: "Send Welcome Email?",
        text: "A welcome email with the fee receipt will be sent to the student.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, send it!"
    }).then((result) => {
        if (result.isConfirmed) {
            // ✅ Show loading spinner before AJAX starts
            Swal.fire({
                title: "Sending...",
                text: "Please wait while we send the welcome email.",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/send-welcome-mail/' + studentId,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (res) {
                    if (res.success) {
                        Swal.fire({
                            title: "Sent!",
                            text: "Welcome email sent successfully 🎉",
                            icon: "success"
                        });
                    } else {
                        Swal.fire({
                            title: "Failed!",
                            text: "Error: " + res.message,
                            icon: "error"
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Oops...",
                        text: "Something went wrong while sending email.",
                        icon: "error"
                    });
                }
            });
        }
    });
}



</script>

@endsection
