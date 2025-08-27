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
                                <!-- <div>
                  <a class="btn btn-primary btn-sm me-2" href="javascript:void(0);" onclick="addReceiveFee();" role="button">+ ledgers FEE</a>
                </div> -->
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
                                        @foreach ($ledgers ?? '' as $index => $ledgers)
                                        <?php
                        $total_due = 0;
                        $ledger_datas = App\Models\Ledger::where('student_id', $ledgers->id)
                        ->get();
                    ?>
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>
                                                <strong>{{$ledgers->name}}</strong>
                                                <br>{{$ledgers->phone}}
                                                <br>{{$ledgers->email}}
                                            </td>
                                            <td>
                                                @foreach($ledger_datas as $ledger_data)
                                                {{$ledger_data->provided_transaction_id}}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{$ledgers->total_fee}}<br>
                                            </td>
                                            {{-- <td>
                                                @foreach($ledger_datas as $ledger_data)
                                                <span class="d-flex justify-content-around mb-2">
                                                    {{$ledger_data->fee_received}} ({{$ledger_data->created_at}})<a
                                                        href="{!! route('downloadInvoice', ['id'=>$ledger_data->id]) !!}"
                                                        class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                            class="fas fa-download"></i></a></span>
                                                @endforeach
                                            </td> --}}
                                            {{-- <td>
                                                @foreach($ledger_datas as $ledger_data)
                                                <span class="d-flex justify-content-between align-items-center mb-2">
                                                    {{ $ledger_data->fee_received }} ({{ $ledger_data->created_at }})

                                                    @if($ledger_data->approval_status == 'pending')
                                                    <a href="javascript:void(0);"
                                                        class="badge bg-warning text-dark ms-2"
                                                        onclick="showFeeDetails('{{ $ledger_data->id }}')">
                                                        Pending
                                                    </a>
                                                    @elseif($ledger_data->approval_status == 'approved')
                                                    <a href="{!! route('downloadInvoice', ['id'=>$ledger_data->id]) !!}"
                                                        class="btn btn-primary shadow btn-xs sharp ms-2">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    @elseif($ledger_data->status == 'rejected')
                                                    <span class="badge bg-danger ms-2">Rejected</span>
                                                    @endif
                                                </span>
                                                @endforeach
                                            </td> --}}
                                            <td>
                                                @foreach($ledger_datas as $ledger_data)
                                                <span class="d-flex justify-content-between align-items-center mb-2">
                                                    {{ $ledger_data->fee_received }} ({{ $ledger_data->created_at }})

                                                    @if($ledger_data->approval_status == 0)
                                                    <a href="javascript:void(0);"
                                                        class="badge bg-warning text-dark ms-2"
                                                        onclick="showFeeDetails('{{ $ledger_data->id }}')">
                                                        Pending
                                                    </a>
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
                                                @foreach( $ledger_datas as $ledger_data)
                                                {{$ledger_data->due_ammount}}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);"
                                                    onclick="addReceiveFee('{{ $ledgers->student_id }}');"
                                                    class="btn btn-success shadow btn-xs sharp me-1"><i
                                                        class="fas fa-plus-circle"></i></a>
                                                <!-- <a href="{!! route('downloadInvoice', ['id'=>$ledgers->student_id]) !!}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-download"></i></a> -->
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
</script>
@endsection
