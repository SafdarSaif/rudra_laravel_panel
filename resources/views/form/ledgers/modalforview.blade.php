<div class="p-3">
    <h5 class="mb-3">Student Fee Details</h5>
    <table class="table table-bordered">
        <tr>
            <th>Student Name</th>
            <td>{{ $ledger->student->name ?? '' }}</td>
        </tr>
        <tr>
            <th>Transaction ID</th>
            <td>{{ $ledger->transaction_id  }}</td>
        </tr>
        <tr>
            <th>Provided Transaction ID</th>
            <td>{{ $ledger->provided_transaction_id }}</td>
        </tr>
        <tr>
            <th>Fee Received</th>
            <td>{{ $ledger->fee_received }}</td>
        </tr>
        <tr>
            <th>Due Amount</th>
            <td>{{ $ledger->due_ammount }}</td>
        </tr>
        {{-- <tr>
            <th>Status</th>
            <td>
                @if($ledger->approval_status == 0)
                    <span class="badge bg-warning text-dark">Pending</span>
                @elseif($ledger->approval_status == 1)
                    <span class="badge bg-success">Approved</span>
                @elseif($ledger->approval_status == 2)
                    <span class="badge bg-danger">Rejected</span>
                @endif
            </td>
        </tr> --}}
        <tr>
            <th>Date</th>
            <td>{{ $ledger->created_at }}</td>
        </tr>
        <tr>
            <th>Attachment</th>
            <td>
                @if($ledger->file)
                    <a href="{{ asset('admin/attachement/'.$ledger->file) }}" target="_blank" class="btn btn-sm btn-info">
                        View Attachment
                    </a>
                @else
                    <span class="text-muted">No Attachment</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="d-flex justify-content-end mt-3">
        @if($ledger->approval_status == 0)
            <button class="btn btn-success me-2" onclick="updateFeeStatus({{ $ledger->id }}, 1)">Approve</button>
            <button class="btn btn-danger" onclick="updateFeeStatus({{ $ledger->id }}, 2)">Reject</button>
        @endif
    </div>
</div>
