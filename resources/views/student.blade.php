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
                                <h4 class="heading mb-0">Students</h4>
                                <div>
                                    <a class="btn btn-primary btn-sm me-2" href="javascript:void(0);"
                                        onclick="add_student();" role="button">+ Punch Student</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="example3" class="display table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Added By</th>
                                            <th>Student details</th>
                                            <th>Academic</th>
                                            <th>session</th>
                                            <th>dob</th>
                                            <th>Total Fee</th>
                                            <th>Registration Fee</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students ?? '' as $index => $student)
                                        {{-- @php
                                        $balance_due = 0;
                                        $balances = App\Models\Ledger::where('student_id', $student->id)->get();
                                        foreach($balances as $balance){
                                        $balance_due = $balance_due + (int)$balance->fee_received;
                                        }
                                        $user = App\Models\User::where('id', $student->owner_id)->first();
                                        $acadmics = App\Models\Acadmics::where('student_id', $student->id)->get();
                                        @endphp --}}
                                        @php
                                        $balance_due = 0;

                                        // Get only approved ledgers for this student
                                        $balances = App\Models\Ledger::where('student_id', $student->id)
                                        ->where('approval_status', 1)
                                        ->get();

                                        foreach ($balances as $balance) {
                                        $balance_due += (int)$balance->fee_received;
                                        }

                                        $user = App\Models\User::where('id', $student->owner_id)->first();
                                        $acadmics = App\Models\Acadmics::where('student_id', $student->id)->get();
                                        @endphp

                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>
                                                <span class="d-flex justify-content-around mb-2">
                                                    <a href="javascript:void(0);"
                                                        onclick="add_acadmics('{{$student->id}}');"
                                                        class="btn btn-success shadow btn-xs sharp me-1"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                    @if(count($acadmics) >0)
                                                    <a href="{!! route('downloadfrom', ['id'=>$student->id]) !!}"
                                                        class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                            class="fas fa-download"></i></a>
                                                    @else
                                                    <a href="javascript:void(0);"
                                                        onclick="show_acadmics('{{$student->id}}');"
                                                        class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                            class="fas fa-download"></i></a>
                                                    @endif
                                                    @if($user)
                                                    <p class="h6">{{$user->name}}</p>
                                                    @else
                                                    <p class="h6"> Admin</p>
                                                    @endif
                                                </span>

                                            </td>
                                            <td>
                                                <strong>{{$student->name}}</strong>
                                                <br>{{$student->phone}}
                                                <br>{{$student->email}}
                                            </td>

                                            <td>
                                                <strong>{{$student->unversity_name}} </strong>
                                                <br>{{$student->course_name}}
                                                <br>{{$student->sub_course}}
                                            </td>
                                            <td>{{$student->session}}</td>
                                            <td>{{$student->dob}}</td>
                                            <td>{{$student->total_fee}}</td>
                                            <td>{{$student->registration_fee}}</td>
                                            <td>{{(int)$student->total_fee - (int)$balance_due}}</td>
                                            <td>
                                                <a href="javascript:void(0);"
                                                    onclick="addReceiveFee('{{ $student->id }}');"
                                                    class="btn btn-success shadow btn-xs sharp me-1"><i
                                                        class="fas fa-plus-circle"></i></a>
                                                <a href="javascript:void(0);"
                                                    onclick="edit_student('{{ $student->id }}');"
                                                    class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                @if(Auth::guard('webadmin')->user()->roles == "Admin")
                                                <a href="javascript:void(0);"
                                                    onclick="deletestudent('{{$student->id}}');"
                                                    class="btn btn-danger shadow btn-xs sharp"><i
                                                        class="fa fa-trash"></i></a>
                                                @endif
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
    function add_student() {
    $.ajax({
      url: '/create_student',
      success: function(data) {
        $('#add_modal_content').html(data);
        $('#add_modal').modal('show');
      }
    })
  }

  function add_acadmics(id) {
    $.ajax({
      url: '/add_adcadmics/'+id,
      success: function(data) {
        $('#add_modal_content').html(data);
        $('#add_modal').modal('show');
      }
    })
  }

  function show_acadmics(){
    Swal.fire(
      'Oops!',
      'Please add adcadmics details first!!.',
      'error'
    )
  }

  function edit_student(id) {
    $.ajax({
      url: '/edit_student/' + id,
      success: function(data) {
        $('#add_modal_content').html(data);
        $('#add_modal').modal('show');
      }
    })
  }
</script>
<script>
    function deletestudent(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/deletestudent/' + id,
          success: function(data) {
            if (data.status == 200) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              setTimeout(() => {
                window.location.reload();
              }, 1000);
            } else {
              Swal.fire(
              'Oops!',
              'This student ladgers exist!!.',
              'error'
              )
            }
          }
        })

      }
    })
  }
</script>
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
